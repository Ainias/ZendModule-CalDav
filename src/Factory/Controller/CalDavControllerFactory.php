<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.11.16
 * Time: 18:31
 */

namespace Ainias\CalDav\Factory\Controller;


use Ainias\CalDav\Controller\CalDavController;
use Ainias\CalDav\NoDb\Essentials\PropertyFilterParser;
use Ainias\CalDav\NoDb\Essentials\PropertyRepository;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CalDavControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var PropertyFilterParser $propertyFilterParser */
        $propertyFilterParser = $container->get(PropertyFilterParser::class);

        /** @var PropertyRepository $propertyRepository */
        $propertyRepository = $container->get(PropertyRepository::class);

        return new CalDavController($propertyFilterParser, $propertyRepository);
    }
}