<?php

namespace Ainias\CalDav;

use Ainias\CalDav\Controller\CalDavController;
use Ainias\CalDav\Factory\Controller\CalDavControllerFactory;

return array(
    'controllers' => [
        'factories' => [
            CalDavController::class => CalDavControllerFactory::class,
        ],
    ],
);