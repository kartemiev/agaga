<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SettingsController extends AbstractActionController
{
 public function indexAction()
 {
     return $this->getSubMenuMap();
 }
 public function groupsAction()
 {
     return $this->getSubMenuMap();      
 } 
 protected function getSubMenuMap()
 {
     $viewModel = new ViewModel();
     $viewModel->setTemplate('vpbxui/submenumap/index.phtml');
     return $viewModel;      
 }   
}