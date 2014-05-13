<?php

namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CallCentreStatsOperatorsController extends AbstractActionController
{
  protected $operatorStatTable;
    public function indexAction()
    {
     $operatorStatTable = $this->getOperatorStatTable();
     $operatorStat = $operatorStatTable->fetchAll();
     return new ViewModel(array(
         'operatorstat' => $operatorStat         
     ));
    }
    
    public function dailyAction()
    {
        return new ViewModel();
        
    }
    public function monthlyAction()
    {
        return new ViewModel();
        
    }
    public function integralAction()
    {
        return new ViewModel();
        
    }
    protected function getOperatorStatTable()
    {
        if (!$this->operatorStatTable){
            $sm = $this->serviceLocator;
            $this->operatorStatTable = $sm->get('Vpbxui\OperatorStat\Model\OperatorStatTable');            
        }
        return $this->operatorStatTable;
    }
    
}