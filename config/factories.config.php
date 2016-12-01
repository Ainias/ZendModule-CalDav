<?php

namespace Ainias\CalDav;

use Ainias\CalDav\Factory\Essentials\CalDavBasicResolverFactory;
use Ainias\CalDav\Factory\Essentials\PropertyFilterParserFactory;
use Ainias\CalDav\Factory\Essentials\PropertyRepositoryFactory;
use Ainias\CalDav\NoDb\Essentials\DummyBasicResolver;
use Ainias\CalDav\NoDb\Essentials\PropertyFilterParser;
use Ainias\CalDav\NoDb\Essentials\PropertyRepository;

return array(
    'service_manager' => array(
        'abstract_factories' => array(
        ),
        'aliases' => array(
            'calDavBasicResolver' => DummyBasicResolver::class,
        ),
        'factories' => array(
            PropertyFilterParser::class => PropertyFilterParserFactory::class,
            PropertyRepository::class => PropertyRepositoryFactory::class,
            DummyBasicResolver::class => CalDavBasicResolverFactory::class,
        ),
    ),
);