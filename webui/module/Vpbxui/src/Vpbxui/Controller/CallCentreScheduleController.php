<?php
namespace Vpbxui\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTable; 
use Vpbxui\CallCentreSchedule\Form\CallCentreScheduleForm;
use Vpbxui\CallCentreSchedule\Model\TimeSpotTableInterface;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate\Like;
use Zend\View\Model\JsonModel;

class CallCentreScheduleController extends AbstractActionController {

	public $callCentreScheduleTable;
	public $timeSpotTable;
	public function __construct(CallCentreScheduleTable $callCentreScheduleTable, TimeSpotTableInterface $timeSpotTable)
	{
		$this->callCentreScheduleTable = $callCentreScheduleTable;
		$this->timeSpotTable = $timeSpotTable;
	}
   
     public function indexAction()
     {
         
		 $callCentreSchedule = $this->callCentreScheduleTable->getCallCentreSchedule(1);          
         $form = new CallCentreScheduleForm();
     
         $form->bind($callCentreSchedule);
         $form->get('submit')->setAttribute('value', 'Сохранить');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($callCentreSchedule->getInputFilter());
             $form->setData($request->getPost());
     
             if ($form->isValid()) {
            
                 $this->callCentreScheduleTable->saveCallCentreSchedule($form->getData());
                 $this->flashMessenger()->addMessage("Настройки расписания сохранены");                  
                 return $this->redirect()->toRoute('vpbxui/callcentresettings');
             }
           
          
         }
         $this
         ->getServiceLocator()
         ->get('viewhelpermanager')
         ->get('HeadScript')
         ->appendFile('/js/select2.custom.js')
         ;
       
         return array(
             'form' => $form,
             'callcentreschedule' => $callCentreSchedule,
         	 'flashMessages' => $this->flashMessenger()->getMessages()         		 
         );
     }
     public function dateAction()
     {
     	$like = $this->params()->fromQuery('q');
     	$like = ($like)?$like:'';
   /*    	if (null==$like)
     	{	
     		$viewmodel  = new JsonModel(
     				array('value'=>'12:00')
     		);
     		$viewmodel->setJsonpCallback($this->params()->fromQuery('callback'));     	
     		return $viewmodel;	 
     	}*/
     	$page = $this->params()->fromQuery('page');
     	$page = ($page)?$page:1;
     	$limit = $this->params()->fromQuery('page_limit');
     	$limit = ($limit)?$limit:50;
     	
     	$offset = ($page-1)*$limit;
     	
     	$where = new Where();
     	
     	$where->addPredicate(
     			new Like("spot", "{$like}%")
     	);
     	
     	
     	$timeSpotTable = $this->timeSpotTable;
     	$resultset = $timeSpotTable->fetchaAll($where,$limit,$offset);
      	$resultSetFullCount = $timeSpotTable->queryResultCount($where);
     	$total = $resultSetFullCount->num;
     	$results = array();
     	foreach ($resultset as $row)
     	{
     		$obj = new \stdClass();
     		 
     		$obj->id = $row->spot;
     		$obj->text = str_pad(" ".$row->spot." ",20);
     		$results[] = $obj;
     		$obj = null;
     	}
     	$viewmodel  = new JsonModel(
     			array('total'=>$total,'results'=>$results)
     	);
     	$viewmodel->setJsonpCallback($this->params()->fromQuery('callback'));
     	 
     	return  $viewmodel;
     }
     
 
}
 