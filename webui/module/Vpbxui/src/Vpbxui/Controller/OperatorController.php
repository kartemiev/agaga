<?php
namespace Vpbxui\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OperatorController extends AbstractActionController
{
    public function indexAction() {
    $result = $this->forward()->dispatch('Vpbxui\Controller\Internal', array('action' => 'index'));
     $model = new ViewModel();
        $model->setTemplate('userinfo');

}

}