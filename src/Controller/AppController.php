<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ItemRepository;
use Psr\Log\LoggerInterface;

class AppController extends AbstractController
{
    private $em;
    private $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * @Route("/")
     */
    public function read(ItemRepository $repo)
    {
        $items = $repo->findBy([]);
        $this->logConnectionStatus();

        return $this->json($items);
    }

    /**
     * @Route("/insert")
     */
    public function insert()
    {
        $item = new Item();
        $item->setLevel(rand(1, 10000));
        $this->em->persist($item);
        $this->em->flush();
        $this->logConnectionStatus();

        return $this->json($item, Response::HTTP_CREATED);
    }

    /**
     * @Route("/update/{id}")
     */
    public function update(int $id, ItemRepository $repo)
    {
        $item = $repo->find($id);
        $this->logConnectionStatus();

        // will now switch to primary connection
        $item->setLevel(rand(1, 10000));
        $this->em->persist($item);
        $this->em->flush();
        $this->logConnectionStatus();

        return $this->json($item);
    }

    /**
     * @Route("/ping")
     */
    public function ping()
    {
        return new Response('pong');
    }

    private function logConnectionStatus()
    {
        $this->logger->debug(sprintf('Used %s for the previous query.', $this->em->getConnection()->isConnectedToMaster() ? 'PRIMARY' : 'REPLICA'));
    }

}
