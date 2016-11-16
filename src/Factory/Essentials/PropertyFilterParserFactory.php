<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.11.16
 * Time: 17:34
 */

namespace Ainias\CalDav\Factory\Essentials;


use Ainias\CalDav\NoDb\Essentials\DefaultPropertyFilterParser;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PropertyFilterParserFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DefaultPropertyFilterParser();
    }
}