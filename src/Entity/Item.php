<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $hash;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;
        $this->hash = sha1($level);

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'level' => $this->level,
            'hash' => $this->hash,
        ];
    }
}
