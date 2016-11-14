<?php

namespace Ainias\CalDav;

use Ainias\CalDav\View\PropertyRenderer;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'view_helpers' => array(
        'factories' => array(
            PropertyRenderer::class => InvokableFactory::class,
        ),
        'aliases' => [
            "properties" => PropertyRenderer::class,
        ],
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'translator' => array(
    ),
);