<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ainias\CalDav;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $event)
    {
        $serviceManager = $event->getApplication()->getServiceManager();
//        /** @var HttpMethodListener $httpMethodListener */
        $httpMethodListener = $serviceManager->get("HttpMethodListener");
        $httpMethodListener->setAllowedMethods(array_merge($httpMethodListener->getAllowedMethods(), [
            "REPORT",
        ]));

        $event->getApplication()->getEventManager()->attach(
            MvcEvent::EVENT_DISPATCH,
            function (MvcEvent $e) {
                if ($e->getRequest() instanceof Request && $e->getRequest()->getMethod() == 'OPTIONS') {
                    /** @var Response $response */
                    $response = $e->getResponse();

                    $response->getHeaders()->addHeaderLine("ALLOW","OPTIONS, PROPFIND, REPORT, GET, HEAD, ACL");
                    $response->getHeaders()->addHeaderLine("Content-Location", "/calDav/");
//                    $response->getHeaders()->addHeaderLine("Etag", rand(0,999));
//                    $response->getHeaders()->addHeaderLine("Dav", "1, 2, 3, access-control, calendar-access, calendar-schedule; extended-mkcol, bind, addressbook, calendar-auto-schedule, calendar-proxy");
//                    $response->getHeaders()->addHeaderLine("Dav", "calendar-proxy");
//                    extended-mkcol, bind, addressbook,
                    $e->getResponse()->sendHeaders();
                    $e->setViewModel(null);
                    $e->stopPropagation(true);
                }
            },
            1000
        );
    }

    public function getConfig()
    {
        $config = array();
        foreach (glob(__DIR__ . '/../config/*.config.php') as $filename) {
            $config = array_merge_recursive($config, include($filename));
        }
        return $config;
    }
}
