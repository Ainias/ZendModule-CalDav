<?php

namespace Ainias\CalDav;

use Zend\Mvc\Service\ServiceListenerFactory;

return array(
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => ServiceListenerFactory::class,
        ],
    ],
);