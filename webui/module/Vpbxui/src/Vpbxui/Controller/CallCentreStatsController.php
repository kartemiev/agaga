<?php
namespace Vpbxui\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class CallCentreStatsController extends AbstractActionController
{
    protected $callCentreStatTable;
    public function indexAction()
    {
        $ccstats = $this->getCallCentreStatTable()->fetchAll();
        
        $ccstat = ($ccstats->current()) ? $ccstats->current() : null;
        
        return new ViewModel(
            array(
                'ccstat' => $ccstat                
                )
            );
    }
    protected function getCallCentreStatTable()
    {
        
        if (!$this->callCentreStatTable)
        {
            $sm = $this->getServiceLocator();
            $this->callCentreStatTable = $sm->get('Vpbxui\CallCentreStat\Model\CallCentreStatTable');          
        }   
        return $this->callCentreStatTable;
    }
    
}