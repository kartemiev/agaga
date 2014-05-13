<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CallcentreController extends AbstractActionController
{
    public function indexAction() {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('vpbxui/submenumap/index.phtml');
        return $viewModel;
     }
    
}