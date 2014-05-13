<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;
use Vpbxui\Conference\Model\Conference;
use Vpbxui\Conference\Model\ConferenceTableInterface;
use Vpbxui\Conference\Form\ConferenceForm;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\View\Model\JsonModel;
use Vpbxui\ConferenceFree\Model\ConferenceFreeTable;

class ConferenceBookingController extends AbstractActionController
{

    protected $conferenceForm;
    protected $conferenceTable;
    protected $conferenceFreeTable;
    protected $dateTime;
    protected $conference;
    public function __construct(
    		ConferenceForm $conferenceForm, 
    		ConferenceTableInterface $conferenceTable, 
    		\DateTime $dateTime,
			Conference $conference,
    		ConferenceFreeTable $conferenceFreeTable
			)
    {
        $this->conferenceForm = $conferenceForm;
        $this->conferenceTable = $conferenceTable;
        $this->conferenceFreeTable = $conferenceFreeTable;
        $this->dateTime = $dateTime;
        $this->conference = $conference;
    }
   public function getConferenceDurationMap()
   {
   		$secondsPer24Hours = 24*60*60;
   		$secondsPerWeek = 7*24*60*60;
   		return array(
   			'0' => $secondsPer24Hours,
   			'1' => $secondsPerWeek	
   		);	
   }
   public function indexAction()
    {
        $form = $this->conferenceForm;
        $form->get('submit')->setValue('Создать');
		$conferences = $this->conferenceTable->fetchAll();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $conference = $this->conference;
            $form->setInputFilter($conference->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
            	$formData = $form->getData();
                $conference->exchangeArray($formData);
                $freeConference = $this->conferenceFreeTable->fetchAll(array('confnumber'=>$conference->confnumber),1);
                if (0<$freeConference->count())
                {
                	if ($conference->pin)
                	{
                	    $conference->isprotected = 1;
                	}
                	$conferenceDurationMap = $this->getConferenceDurationMap();
                	$durationSeconds = $conferenceDurationMap[$formData['reserveduration']];
                	$date = $this->dateTime;
                	$date->modify("+{$durationSeconds} seconds");
                	$datesettoexpiry = $date->format('Y-m-d H:i:s');
                	$conference->datesettoexpiry = $datesettoexpiry;
                	$this->conferenceTable->saveConference($conference);
                	$this->flashMessenger()->addMessage('конференц-комната <b>'.$conference->confnumber.'</b> успешно создана');                
                	return $this->redirect()->toRoute('createconference');
                }
                else 
                {
                	$this->flashMessenger()->addMessage('конференц-комната <b>'.$conference->confnumber.'</b> уже существует. попробуйте создать комнату с другим номером');                	 
                	return $this->redirect()->toRoute('createconference');                	 
                }
            }
            
        }
        return array(
            'flashMessages' => $this->flashMessenger()->getMessages(),            
        	'conferences'=>$conferences,
            'form' => $form            
        );
    }
   public function fetchAction()
   {
       
       $like = $this->params()->fromQuery('q');
      
       if ($like) 
       {
           $filter = new Predicate();            
           $filter->like('confnumber', $like."%");
       }
       $limit = 10;       
       $confnums = $this->getConferenceFreeTable()->fetchAll($filter,$limit);
        $numbers = array();
       foreach ($confnums as $confnum)
       {
           $obj = new \stdClass();
           $obj->id = (string)$confnum->confnumber;
           $obj->text = (string)$confnum->confnumber;           
           $numbers[] = $obj;            
           $obj = null;
        }
        $this->getServiceLocator()->get('Application')->getEventManager()->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, function($event){
            $event->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'text/javascript');
        }, -10000);
         $viewmodel  = new JsonModel(
          array('results'=>$numbers)
           );
         $viewmodel->setJsonpCallback($this->params()->fromQuery('callback'));
          
       return  $viewmodel;
   }
    protected function getConferenceFreeTable()
    {
        if (!$this->conferenceFreeTable)
        {
            $this->conferenceFreeTable = $this->getServiceLocator()->get('Vpbxui\ConferenceFree\Model\ConferenceFreeTable');
          }
        return $this->conferenceFreeTable;
    }
    
}