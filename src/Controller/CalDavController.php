<?php

namespace Ainias\CalDav\Controller;

use Ainias\CalDav\NoDb\Essentials\DummyBasicResolver;
use Ainias\CalDav\NoDb\Essentials\PropertyFilterParser;
use Ainias\CalDav\NoDb\Essentials\PropertyRepository;
use Zend\Authentication\Adapter\Http;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CalDavController extends AbstractActionController
{
    /** @var PropertyFilterParser */
    private $propertyFilterParser;

    /** @var PropertyRepository */
    private $propertyRepository;

    /** @var  Http\ResolverInterface */
    private $basicResolver;

    /**
     * IndexController constructor.
     * @param PropertyFilterParser $propertyFilterParser
     * @param PropertyRepository $propertyRepository
     */
    public function __construct(PropertyFilterParser $propertyFilterParser, PropertyRepository $propertyRepository, Http\ResolverInterface $basicResolver)
    {
        $this->propertyFilterParser = $propertyFilterParser;
        $this->propertyRepository = $propertyRepository;
        $this->basicResolver = $basicResolver;
    }

    public function indexAction()
    {
        if (!$this->isAllowed())
        {
            return $this->getResponse();
        }

        /** @var Request $request */
        $request = $this->getRequest();

        $propertyFilter = $this->propertyFilterParser->parseXmlToPropertyFilter($request->getContent());
        $propertyHref = $this->params("propertyHref", null);

        if ($propertyHref != null) {
            $propertyFilter->setRootHref($propertyHref);
        }

        $properties = $this->propertyRepository->query($propertyFilter);

        /** @var Response $response */
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine("Content-Type", ' text/xml; charset="utf-8"');
        $response->setStatusCode(207); //Multi-Status

        $this->layout("layout/ajaxData");
        return new ViewModel([
            "properties" => $properties,
        ]);
    }

    public function isAllowed()
    {
        $authConfig = [
            'accept_schemes' => 'basic',
            'realm'          => 'Kalender',
            'digest_domains' => '/',
            'nonce_timeout'  => 3600,
        ];

        $authentifiactionAdapter = new Http($authConfig);

        $authentifiactionAdapter->setBasicResolver($this->basicResolver);

        $authentifiactionAdapter->setRequest($this->getRequest());
        $authentifiactionAdapter->setResponse($this->getResponse());
        return $authentifiactionAdapter->authenticate()->isValid();
    }
}
