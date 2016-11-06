<?php

namespace Ainias\CalDav;

use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'calDav' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/calDav',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                        'resource' => 'default',
                    ],
                ],
            ],
        ],
    ],
);