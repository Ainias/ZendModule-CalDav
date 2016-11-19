<?php

namespace Ainias\CalDav;

use Ainias\CalDav\Controller\CalDavController;
use Zend\Router\Http\Method;
use Zend\Router\Http\Segment;

return array(
    'router' => [
        'routes' => [
            'calDav' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/calDav[/[:propertyHref]]',
                    'constaints' => [
                        'propertyHref' => ''
                    ],
                    'defaults' => [
                        'controller' => CalDavController::class,
                        'action'     => 'index',
                        'resource' => 'default',
                    ],
                ],
            ],
        ],
    ],
);