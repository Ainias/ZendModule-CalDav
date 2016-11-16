<?php

namespace Ainias\CalDav\Controller;

use Ainias\CalDav\NoDb\Essentials\DummyRepository;
use Ainias\CalDav\NoDb\Essentials\PropertyFilterParser;
use Ainias\CalDav\NoDb\Essentials\PropertyRepository;
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

    /**
     * IndexController constructor.
     * @param PropertyFilterParser $propertyFilterParser
     * @param PropertyRepository $propertyRepository
     */
    public function __construct(PropertyFilterParser $propertyFilterParser, PropertyRepository $propertyRepository)
    {
        $this->propertyFilterParser = $propertyFilterParser;
        $this->propertyRepository = $propertyRepository;
    }

    public function indexAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        $propertyFilter = $this->propertyFilterParser->parseXmlToPropertyFilter($request->getContent());
        $properties = $this->propertyRepository->query($propertyFilter);

        //TODO löschen, wenn Logik einmal funktioniert
        if (strpos($request->getContent(), "getcontenttype") !== false)
        {
            /** @var DummyRepository $propertyRepository */
            $propertyRepository = $this->propertyRepository;
            $properties = $propertyRepository->propfindEvents();
        }
        else if ($request->getMethod() == "REPORT")
        {
            /** @var DummyRepository $propertyRepository */
            $propertyRepository = $this->propertyRepository;
            $properties = $propertyRepository->calendarQuery($propertyFilter);
        }

        /** @var Response $response */
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine("Content-Type", ' text/xml; charset="utf-8"');
        $response->setStatusCode(207); //Multi-Status

        $this->layout("layout/ajaxData");
        return new ViewModel([
            "properties" => $properties,
        ]);
    }
}
