<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 01.12.16
 * Time: 13:46
 */

namespace Ainias\CalDav\Factory\Essentials;


use Ainias\CalDav\NoDb\Essentials\DummyBasicResolver;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CalDavBasicResolverFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DummyBasicResolver();
    }
}