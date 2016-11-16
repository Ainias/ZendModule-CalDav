<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.11.16
 * Time: 17:38
 */

namespace Ainias\CalDav\Factory\Essentials;


use Ainias\CalDav\NoDb\Essentials\DummyRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PropertyRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DummyRepository();
    }
}