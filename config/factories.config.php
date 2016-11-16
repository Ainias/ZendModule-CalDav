<?php

namespace Ainias\CalDav;

use Ainias\CalDav\Factory\Essentials\PropertyFilterParserFactory;
use Ainias\CalDav\Factory\Essentials\PropertyRepositoryFactory;
use Ainias\CalDav\NoDb\Essentials\PropertyFilterParser;
use Ainias\CalDav\NoDb\Essentials\PropertyRepository;

return array(
    'service_manager' => array(
        'abstract_factories' => array(
        ),
        'aliases' => array(
        ),
        'factories' => array(
            PropertyFilterParser::class => PropertyFilterParserFactory::class,
            PropertyRepository::class => PropertyRepositoryFactory::class,
        ),
    ),
);