<?php
namespace  Vpbxui\Controller;
use Zend\Mvc\Controller\AbstractActionController;

 use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class CdrMissedCallsCallCentreController extends AbstractActionController {
       protected $CdrMissedCallsCallCentreTable;
       protected $extensionTable;
    public function indexAction()
    {       
       $scope = $this->extractScopeParam(1);
       $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 99999999;
       $itemsPerPage = 20;
        
       $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;

        $orderseq = $order_by . ' ' . $order;        
         $filter = $this->ReportScopeFilterControllerPlugin()->getFilterbyScope($scope);
        
        
         $select = new Select();
        $select->order($order_by . ' ' . $order);
        $orderseq = $order_by . ' ' . $order;
         
        $cdrsmissedcalls =  $this->getCdrMissedCallsCallCentreTable()->fetchAll($select, $filter,$orderseq);      
        $paginator = new Paginator(new paginatorIterator($cdrsmissedcalls));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(10);
 
        $this
    ->getServiceLocator()
    ->get('viewhelpermanager')
    ->get('HeadScript')
                     ->appendFile('/js/cdr.js')
;
     $operatorsList = $this->getOperatorList();       
     
          return new ViewModel(array(
             'operatorslist' =>$operatorsList,
             'cdrsmissedcalls' => $cdrsmissedcalls,
                    'page' => $page,
                    'paginator' => $paginator,
                'order_by' => $order_by,
                    'order' => $order,
                    
        ));
    }
     

    protected function getOperatorList()
    {
        $extensionTable = $this->getExtensionTable();
        $operatorList = $extensionTable->getOperatorList();
        $operators = array();
        foreach ($operatorList as $operator)
        {
            $operators[] = (string)$operator->extension;
        }       
        return $operators;
    }

    protected function getExtensionTable()
    {
          
     	if (!$this->extensionTable) {
     		$sm = $this->getServiceLocator();
     		$this->extensionTable = $sm->get('Vpbxui\Extension\Model\ExtensionTable');
     	}
     	return $this->extensionTable;
    }


    public function getCdrMissedCallsCallCentreTable() {
          
     	if (!$this->CdrMissedCallsCallCentreTable) {
     		$sm = $this->getServiceLocator();
     		$this->CdrMissedCallsCallCentreTable = $sm->get('Vpbxui\CdrMissedCallsCallCentre\Model\CdrMissedCallsCallCentreTable');
     	}
     	return $this->CdrMissedCallsCallCentreTable;
     }
     
      public function extractScopeParam($offset)
    {
     $path = explode('/', $this->getRequest()->getUri()->getPath());
      for ($counter=1; $counter<=$offset; $counter++):
         array_pop($path);
     endfor;
     $scope = array_pop($path);
     return $scope;
    }
}

