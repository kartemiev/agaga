<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Vpbxui\Offday\Model\Offday;
use Vpbxui\Offday\Form\OffdayForm;
use Vpbxui\Offday\Form\OffdayRangeFilterForm;
use Zend\Db\Sql\Where;
use Vpbxui\Offday\Form\OffdayImportForm;
 
class OffdayController extends AbstractActionController {
    
    protected $offdayTable;
    protected $query = array();
    protected $filters = array();
    
    public function indexAction()
    {
       $searchform = new OffdayRangeFilterForm();
       $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
       
       $request = $this->getRequest();
        
        
       $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'calldate';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;

         if ($request->isPost()) {
            $startdate = $request->getPost('startdate');
            $enddate = $request->getPost('enddate');
            $itemsPerPage = $request->getPost('itemsperpage');
            $params = $this->params()->fromRoute();
            $query = array();
            if (isset($startdate)) $query['startdate'] = $startdate;
            if (isset($enddate)) $query['enddate'] = $enddate;
            if (isset($itemsPerPage)) $query['itemsperpage'] = $itemsPerPage;                        
            return $this->redirect()->toRoute('vpbxui/settings/offdays',$params,array('query'=>$query));
        }   else 
        {     
            $startdate = $this->params()->fromQuery('startdate');
            $enddate = $this->params()->fromQuery('enddate');
            $itemsPerPage = $this->params()->fromQuery('itemsperpage');                        
        }
        $itemsPerPage = (isset($itemsPerPage))?$itemsPerPage:20;
        
        if (!isset($startdate)) $startdate = date('Y-m-d'); 
        if (!isset($enddate)) $enddate =  '2020-12-31';
            
        $searchform->get('startdate')->setValue($startdate);
        $searchform->get('enddate')->setValue($enddate);
        $searchform->get('itemsperpage')->setValue($itemsPerPage);
        
        $orderseq = $order_by . ' ' . $order;

        $select = new Select();
        $select->order($order_by . ' ' . $order);
        $orderseq = $order_by . ' ' . $order;
         $filter = new Where();
        $filter->between('rdate', $startdate, $enddate)
                    ->AND
                    ->greaterThanOrEqualTo('rdate', 'now()');
          $offdays =  $this->getOffdayTable()->fetchAll($select, $filter,$orderseq);      
        $paginator = new Paginator(new paginatorIterator($offdays));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(10);
 

         return new ViewModel(array(
             'offdays' => $offdays,
             'searchform' => $searchform,
                    'page' => $page,
                    'paginator' => $paginator,
                'order_by' => $order_by,
                    'order' => $order,
             'startdate'=>$startdate,
             'enddate'=>$enddate,
             'itemsperpage'=>$itemsPerPage,
             'flashMessages' => $this->flashMessenger()->getMessages(),              
                    
        ));
     }
   
     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('vpbxui/settings/offdays', array(
                 'action' => 'add'
             ));
         }
         $offday = $this->getOffdayTable()->getOffday($id);
          
         $form = new OffdayForm();
     
         $form->bind($offday);
         $form->get('submit')->setAttribute('value', 'Сохранить');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($offday->getInputFilter());
             $form->setData($request->getPost());
     
             if ($form->isValid()) {
                 $this->getOffdayTable()->saveOffday($form->getData());
                 $offdayName = $form->getData()->name;
                 $this->flashMessenger()->addMessage("Настройки для {$offdayName} сохранены");
                  
                 $this->redirect()->toRoute('vpbxui/settings/offdays',$this->getQuery());
             }
         }
         $this
         ->getServiceLocator()
         ->get('viewhelpermanager')
         ->get('HeadScript')
         ->appendFile('/js/select2.custom.js')
         ;
         return array(
             'id' => $id,
             'form' => $form,
             'offday' => $offday
         );
     }
     
     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('vpbxui/settings/offdays',$this->getQuery());
         }
     
         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'Нет');
     
             if ($del == 'Да') {
                 $id = (int) $request->getPost('id');
                 $extension = $this->getOffdayTable()->getOffday($id);
                 $this->getOffdayTable()->deleteOffday($id);
             }
     
             // Redirect to list of albums
             return $this->redirect()->toRoute('vpbxui/settings/offdays',$this->getQuery());
         }
     
         return array(
             'id'    => $id,
             'offday' => $this->getOffdayTable()->getOffday($id)
         );
     }
     
     public function addAction()
     {
         $form = new OffdayForm;
         $form->get('submit')->setValue('Добавить');
          
         $request = $this->getRequest();
         if ($request->isPost()) {
             $offday = new Offday();
             $form->setInputFilter($offday->getInputFilter());
             $form->setData($request->getPost());
     
             if ($form->isValid()) {
                 $offday->exchangeArray($form->getData());
                 unset($offday->id);                 
                 $recordexists = $this->getOffdayTable()->getOffdayByDate($offday->rdate);
                 if ($recordexists)
                 {
                     $this->flashMessenger()->addMessage('Ошибка сохранения - запись для '.$offday->rdate.' уже существует');                      
                 }
                 else
                 {    
                    $this->getOffdayTable()->saveOffday($offday);
                 }
                 return $this->redirect()->toRoute('vpbxui/settings/offdays',$this->getQuery());
             }              
         }              
         $form->get('start_time')->setValue('00:00');
         $form->get('end_time')->setValue('00:00');          
         $this
         ->getServiceLocator()
         ->get('viewhelpermanager')
         ->get('HeadScript')
         ->appendFile('/js/select2.custom.js')
         ;
         return array('form' => $form,
             'flashMessages' => $this->flashMessenger()->getMessages(),
         );
     }
     public function importAction()
     {
         $form = new OffdayImportForm('upload-form');

    $request = $this->getRequest();
    if ($request->isPost()) {
        // Make certain to merge the files info!
        $post = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );

        $form->setData($post);
        if ($form->isValid()) {
            $data = $form->getData();
            var_dump($data);
            
            exit;
            $file = new \SplFileObject("animals.csv");
            $file->setFlags(\SplFileObject::READ_CSV);
            foreach ($file as $row) {
                list($animal, $class, $legs) = $row;
                printf("A %s is a %s with %d legs\n", $animal, $class, $legs);
            }
             $this->flashMessenger()->addMessage('Успешно импортировано');            
            return $this->redirect()->toRoute('vpbxui/settings/offdays');
        }
    }

        return array('form' => $form);
     }
     public function exportAction()
     {
         
        $offday = $this->getOffdayTable()->fetchAll(new Select())
                ->toArray();
        $columnHeaders = array('дата','рабочий','короткий');
        array_walk($columnHeaders, function(&$value,$key){
            $value = iconv('UTF-8', 'Windows-1251', $value);
        });
          return $this->csvAction('offdays.csv', $offday, $columnHeaders);
     }
     
     protected function csvAction($filename, $resultset,$columnHeaders = null)
     {         
         $view = new ViewModel();
         $view->setTemplate('download/download-csv')
         ->setVariable('results', $resultset)
         ->setTerminal(true);
        
         if (!empty($columnHeaders)) {
             $view->setVariable(
     
                 'columnHeaders', $columnHeaders
             );
         }
     
         $output = $this->getServiceLocator()
         ->get('viewrenderer')
         ->render($view);
     
         $response = $this->getResponse();
     
         $headers = $response->getHeaders();
         $headers->addHeaderLine('Content-Type', 'text/csv')
         ->addHeaderLine(
     
             'Content-Disposition',
             sprintf("attachment; filename=\"%s\"", $filename)
         )
         ->addHeaderLine('Accept-Ranges', 'bytes')
         ->addHeaderLine('Content-Length', strlen($output));
     
         $response->setContent($output);
     
         return $response;
     }
     public function getOffdayTable() {
     	if (!$this->offdayTable) {
     		$sm = $this->getServiceLocator();
     		$this->offdayTable = $sm->get('Vpbxui\Offday\Model\OffdayTable');
     	}
     	return $this->offdayTable;
     }
     public function addQueryParam($queryParam) {
         $this->query[] = $queryParam;
         return $this;
     }
     
     public function getQuery() {
         return $this->query;
     }
     public function getFilters() {
         return $this->filters;
     }
     
     public function addFilter($filter) {
         $this->filters[key($filter)] = array_shift(array_values($filter));
         return $this;
     }    
}
 