<?php

namespace Ainias\CalDav\Controller;

use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function getCalendarsAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $viewModel = new ViewModel();
//        $viewModel->setTemplate("layout/blank");
        $this->layout("layout/blank");

        return $viewModel;
    }
}
