<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class CallCentreMonitoringController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}