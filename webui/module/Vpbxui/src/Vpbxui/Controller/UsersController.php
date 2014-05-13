<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsersController extends AbstractActionController
{
    public function indexAction() {
        $viewModel = new ViewModel(array('title' => 'пользователи'));
        $viewModel->setTemplate('vpbxui/submenumap/index.phtml');
        return $viewModel;
     }    
}