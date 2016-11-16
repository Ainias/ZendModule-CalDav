<?php

namespace Ainias\CalDav;

use Ainias\CalDav\Controller\IndexController;
use Zend\Router\Http\Method;
use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'calDav' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/calDav[/]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'getCalendars',
                        'resource' => 'default',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'users' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => 'users[/]',
                            'defaults' => [
                                'controller' => IndexController::class,
                                'action'     => 'getUsers',
                                'resource' => 'default',
                            ],
                        ],
                    ],
                    'appointment' => [
                        'type' => Method::class,
                        'options' => [
                            'verb'    => 'REPORT',
                            'defaults' => [
                                'controller' => IndexController::class,
                                'action'     => 'getAppointment',
                                'resource' => 'default',
                            ],
                        ],
                    ],
                    'calDavOptions' => [
                        'type' => Method::class,
                        'options' => [
                            'verb' => 'options',
                            'defaults' => [
                                'contoller' => IndexController::class,
                                'action' => 'getUsers',
                                'resource' => 'default'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
);