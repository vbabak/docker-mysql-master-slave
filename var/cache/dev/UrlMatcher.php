<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/' => [[['_route' => 'app_app_read', '_controller' => 'App\\Controller\\AppController::read'], null, null, null, false, false, null]],
        '/insert' => [[['_route' => 'app_app_insert', '_controller' => 'App\\Controller\\AppController::insert'], null, null, null, false, false, null]],
        '/ping' => [[['_route' => 'app_app_ping', '_controller' => 'App\\Controller\\AppController::ping'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/update/([^/]++)(*:23)'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        23 => [
            [['_route' => 'app_app_update', '_controller' => 'App\\Controller\\AppController::update'], ['id'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
