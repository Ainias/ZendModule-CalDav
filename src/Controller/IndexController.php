<?php

namespace Ainias\CalDav\Controller;

use Ainias\CalDav\NoDb\ICalendar\VEvent;
use Ainias\CalDav\NoDb\Property;
use Ainias\CalDav\NoDb\PropertyFilter;
use Ainias\CalDav\NoDb\Repository\DummyRepository;
use Ainias\CalDav\NoDb\Request\RequestManager;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function getCalendarsAction()
    {
        $this->logRequest();
        /** @var Request $request */
        $request = $this->getRequest();
        $method = $request->getMethod();

        $propertyFilter = new PropertyFilter();
        $propertyFilter->addField(Property::PROP_DISPLAY_NAME);
        $propertyFilter->addField(Property::PROP_CTAG);

        $dummyRepository = new DummyRepository();

        if ($method == "REPORT") {
            $properties = $dummyRepository->calendarQuery($propertyFilter);
        } else if ($method == "PROPFIND") {
            $properties = $dummyRepository->propfind($propertyFilter);
        } else {
            return $this->triggerDispatchError();

        }

        $viewModel = new ViewModel();
        $viewModel->setVariable("properties", $properties);
        $this->layout("layout/ajaxData");
        $this->getResponse()->setStatusCode(207); //Multi-Status
        return $viewModel;
    }

    public function getUsersAction()
    {
        $this->logRequest();

        /** @var Request $request */
        $request = $this->getRequest();
        $method = $request->getMethod();
        if ($method != "PROPFIND") {
            return $this->triggerDispatchError();
        }
        $content = $request->getContent();

        $viewModel = new ViewModel();
//        $viewModel->setTemplate("layout/blank");
        $this->layout("layout/ajaxData");
        $this->getResponse()->setStatusCode(207); //Multi-Status
        return $viewModel;
    }

    public function getAppointmentAction()
    {
        $this->logRequest();

        /** @var Request $request */
        $request = $this->getRequest();
        $method = $request->getMethod();
        if ($method != "REPORT") {
            return $this->triggerDispatchError();
        }
        $content = $request->getContent();
        $iCalendarManager = new RequestManager();
        $requestObject = $iCalendarManager->extractXML($content);

        $viewModel = new ViewModel();
        if (strpos($content, "sync") > 0) {
            $viewModel->setTemplate("ainias/cal-dav/index/get-appointment-sync");
        } else {
            $vEvent = new VEvent();
            $vEvent->setUid(1);
            $vEvent->setCreated(new \DateTime());
            $vEvent->setDtstamp(new \DateTime());
            $vEvent->setDtstart(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-10 18:30:00"));
            $vEvent->setDtend(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-10 19:30:00"));
            $vEvent->setLastModified(new \DateTime());
            $vEvent->setSummary("Ein Test wird getestet");
            $vEvent->setTransp("OPAQUE");

            $viewModel->setVariable("vEvent", $vEvent->__toString());
            $viewModel->setTemplate("ainias/cal-dav/index/get-appointment");
        }

        /** @var Response $response */
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine("Content-Type", 'text/xml; charset="utf-8"');
        $this->layout("layout/ajaxData");
        $this->getResponse()->setStatusCode(207); //Multi-Status
        return $viewModel;
    }

    protected function triggerDispatchError($statusCode = 404)
    {
        $this->getResponse()->setStatusCode($statusCode);
        $this->getEvent()->setName(MvcEvent::EVENT_DISPATCH_ERROR);
        $this->getEventManager()->triggerEvent($this->getEvent());
        return false;
    }

    protected function logRequest()
    {
        $request = $this->getRequest();
        $this->logValue(PHP_EOL . PHP_EOL);
        $this->logValue($request->toString());

    }

    protected function logValue($value)
    {
        file_put_contents("requestLog", $value . PHP_EOL, FILE_APPEND);
    }
}
