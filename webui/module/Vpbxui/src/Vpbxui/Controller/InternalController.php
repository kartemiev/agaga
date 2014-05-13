<?php

namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Vpbxui\OperatorStatusLog\Model\OperatorStatusLog as OperatorStatusLogEntry;
use Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTableInterface;
use Vpbxui\Extension\Model\ExtensionTableInterface;
use Zend\View\Model\JsonModel;
use Vpbxui\CallDestination\Model\CallDestination;

/**
 * InternalController
 * 
 * @author
 * @version 
 */
class InternalController extends AbstractActionController  {
    protected $extensionTable;
    protected $extensionGroupTable;
    protected $extensionProfileTable;
    protected $operatorStatusLogTable;
    protected $query = array();
    protected $filters = array();
    protected $passwordGen;
    protected $freeExtensionTable;
    protected $extensionForm;
    const SIP_NEWEXTEN_DEFAULT_DENY = '0.0.0.0/0.0.0.0';
    const SIP_NEWEXTEN_DEFAULT_PERMIT = '192.168.6.0/255.255.255.0';
    const SIP_DEFAULT_NUM_LINES = 30;
        public function indexAction()
    {
        $select = new Select();
        $select->order('extension ASC');

        $extensions =  $this->getExtensionTable()->fetchAll($select); 
        $extensionGroups = $this->getExtensionGroupTable()->fetchAll();
        $extensionGroupsArray = array();
        foreach ($extensionGroups as $extensionGroup)
        {
            $extensionGroupsArray[$extensionGroup->id] = $extensionGroup->name;
        }     
        

         return new ViewModel(array(
            'extensions' => $extensions,
             'extensiongroups' =>$extensionGroupsArray,
             'flashMessages' => $this->flashMessenger()->getMessages()              
        ));
    }
    
   public function addAction()
    {        
        $sm = (method_exists($this->serviceLocator, 'getServiceLocator'))?$this->serviceLocator->getServiceLocator():$this->serviceLocator;
        $form = $this->getExtensionForm();
        $form->get('actions')
        ->get('submit')
        ->setLabel('Добавить');
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $sm = $this->serviceLocator;
            $extension = $sm->get('Vpbxui\Extension\Model\Extension');
            $form->setInputFilter($extension->getInputFilter());
            $form->setData($request->getPost());            
            if ($form->isValid()) {
               $extension->exchangeArray($form->getData());          
			
                $id = (int)$this->getExtensionTable()->saveExtension($extension);  
                
                $this->saveCallDestinations($id, $form);
               
                $this->prunePeer($extension->name);
                if (ExtensionTableInterface::EXTENSION_TYPE_OPERATOR == $extension->extensiontype)
                {
                     $this->addOperatorStatusLogEntry($extension->extension, OperatorStatusLogTableInterface::OPERATORSTATUS_ABSENT);
                }                
                 return $this->redirect()->toRoute('vpbxui/internal',$this->getQuery());
            }
         }
        else 
        {
            $profile = $this->params('id');
            if (!isset($profile))
            {
                $this->redirect()->toRoute('vpbxui/internal', array('action' => 'profile'));
            }
            $profile = (int)$profile;
            $extensionProfileTable = $this->getExtensionProfileTable();
            $extensionProfile = $extensionProfileTable->getExtensionProfile($profile);
            unset($extensionProfile->id);
            $form->bind($extensionProfile);
            $form->get('diversion_noanswer_duration')
            	 ->setValue('5');      
           $this->extensionAddSetDefaultFormValues($form);      
        }        
        
         return array('form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages(),     
         );
    }
    
    public function profileAction()
    {
        $sm = (method_exists($this->serviceLocator, 'getServiceLocator'))?$this->serviceLocator->getServiceLocator():$this->serviceLocator;
        $form = $sm->get('Vpbxui\Extension\Form\ExtensionProfilePickerForm');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $sm = $this->serviceLocator;
            $extensionprofile = $sm->get('Vpbxui\Extension\Model\ExtensionProfilePicker');
            $form->setInputFilter($extensionprofile->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
               $extensionprofile->exchangeArray($form->getData());
               $extensionProfileTable = $this->getExtensionProfileTable();
               $extensionProfileRecord = $extensionProfileTable->getExtensionProfile($extensionprofile->profile);
               $profileName = $extensionProfileRecord->profilename;
               if (0==!$extensionProfileRecord->id){
                $this->flashMessenger()->addMessage('Загружены настройки профиля абонента "<b>'.$profileName.'</b>"');        
               }        
                return $this->redirect()->toRoute('vpbxui/internal',
                    array('action'=>'add','id' => $extensionprofile->profile));
            }
        }        
        return array('form' => $form);            
    }
	
 public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vpbxui/internal', array(
                'action' => 'add'
            ));
        }
        $extension = $this->getExtensionTable()->getExtension($id);

        $navigation = $this->getServiceLocator()->get('Navigation');
        $page = $navigation->findBy('id', 'internal'.($extension->id));
        $page->setActive();
/*        $page->addPage(array(
            'uri' => $this->getRequest()->getRequestUri(),//current page URI
            'label' => (string)$extension->extension,//<<<<< product name
            'active' => true,
            'pages'=>array()
        ));*/
        
        
        $sm = $this->getServiceLocator();
        $form = $this->getExtensionForm();
        
 
          $this
        ->getServiceLocator()
        ->get('viewhelpermanager')
        ->get('HeadScript')
        ->appendFile('/js/bootstrap-slider.js')
        ;
        $headLink = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
        $headLink->appendStylesheet('/css/slider.css');      
        
        $form->bind($extension);
         $form->get('actions')
        ->get('submit')
        ->setLabel('Сохранить');
         
         $element = $form->get('diversion_noanswer_duration');
         $element->setAttribute('data-slider-value', $element->getValue());
        
        $extensionElement = $form->get('extension');
        $extensionElement->setAttribute('disabled', 'disabled');
   //     $extensionTypeElement = $form->get('extensiontype');
   //     $extensionTypeElement->setAttribute('disabled', 'disabled');
                
        $options = $extensionElement->getValueOptions();
        $options[$extension->extension] = $extension->extension;
        ksort($options, SORT_NUMERIC);
//        $options[$extension->extension]=$extension->extension;
//        $options  = array_merge($options, $extensionElement->getAttribute('options'));
        
        $extensionElement->setAttribute('options', $options);

        //$extensionElement->setAttribute('disabled', 'disabled');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($extension->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getExtensionTable()->saveExtension($form->getData());

                $this->saveCallDestinations($id, $form);
                
                $peerName = $form->getData()->name;
                 $this->prunePeer($peerName);
                // Redirect to list of albums
                 $this->flashMessenger()->addMessage('Настройки для '.$form->getData()->extension.' сохранены');
                                   
                 $this->redirect()->toRoute('vpbxui/internal',$this->getQuery());
            }
        }
        else 
        {                  	    
        	$this->populateCallDestinationFieldset($id);        	 
        }

        return array(
            'id' => $id,
            'form' => $form,
            'extension' => $extension
         );
    }
	
 public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
     	if (!$id) {
    		return $this->redirect()->toRoute('vpbxui/internal',$this->getQuery());
    	}
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'Нет');
    
    		if ($del == 'Да') {
    			$id = (int) $request->getPost('id');
    			$extension = $this->getExtensionTable()->getExtension($id);    			 
    			$this->getExtensionTable()->deleteExtension($id);
                         $peerName = $extension->name;
                         if (ExtensionTableInterface::EXTENSION_TYPE_OPERATOR == $extension->extensiontype)
                         {
                            $this->addOperatorStatusLogEntry($extension->extension, 
                             OperatorStatusLogTableInterface::OPERATORSTATUS_DELETED);
                         }
                        $this->prunePeer($peerName);
    		}
    
    		// Redirect to list of albums
    		return $this->redirect()->toRoute('vpbxui/internal',$this->getQuery());
    	}
    
    	return array(
    			'id'    => $id,
    			'extension' => $this->getExtensionTable()->getExtension($id)
    	);
    }
	public function getExtensionTable() {
	    if (!$this->extensionTable) {
	    	$sm = $this->getServiceLocator();
	    	$this->extensionTable = $sm->get('Vpbxui\Extension\Model\ExtensionTable');
	    }
		return $this->extensionTable;
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
    protected function prunePeer($peername)
    {
        $serviceLocator = $this->getServiceLocator();
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?
                $serviceLocator->getServiceLocator(): $serviceLocator;
        $pruneCommand = $sl->get('Vpbxui\Prune\Model\PruneCommand');
        $pruneCommand->prunePeer($peername);
        return $this;
    }
    protected function getExtensionGroupTable()
    {
        if (!$this->extensionGroupTable) {
            $sm = $this->getServiceLocator();
            $this->extensionGroupTable = $sm->get('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable');
        }
        return $this->extensionGroupTable;        
        
    }
    protected function getExtensionProfileTable()
    {
        if (!$this->extensionProfileTable) {
            $sm = $this->getServiceLocator();
            $this->extensionProfileTable = $sm->get('Vpbxui\ExtensionProfile\Model\ExtensionProfileTable');
        }
        return $this->extensionProfileTable;
    
    }
    protected function addOperatorStatusLogEntry($extension, $operatorstatus)
    {
        $logEntry = new OperatorStatusLogEntry();
        $logEntry->extension = $extension;
        $logEntry->operatorstatus = $operatorstatus;
        $operatorStatusLogTable = $this->getOperatorStatusLogTable();
        $operatorStatusLogTable->addEntry($logEntry);        
    }
    protected function getOperatorStatusLogTable()
    {
        if (!$this->operatorStatusLogTable)
        {
            $sm = $this->getServiceLocator();
            $this->operatorStatusLogTable = $sm->get('Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTable');
        }
        return $this->operatorStatusLogTable;
    }
    protected function getPasswordGen()
    {
        if (!$this->passwordGen)
        {
            $sm = $this->getServiceLocator();
            $this->passwordGen = $sm->get('Vpbxui\Service\PasswordGen\PasswordGen');
        }
        return $this->passwordGen;
    }
    protected function getFreeExtensionTable()
    {
        if (!$this->freeExtensionTable)
        {
            $sm = $this->getServiceLocator();
            $this->freeExtensionTable = $sm->get('Vpbxui\FreeExtension\Model\FreeExtensionTable');
        }
        return $this->freeExtensionTable;
    }
    protected function extensionAddSetDefaultFormValues($form)
    {
        $name = $form->get('name');
        $freeExtensionTable = $this->getFreeExtensionTable();
        $nextFreeExtensions = $freeExtensionTable->fetchAll(null,1);
        $nextFreeExtension = $nextFreeExtensions->current()->ext;
        $name->setValue($nextFreeExtension);
        
        $secret = $form->get('secret');
        $passwordGen = $this->getPasswordGen();
        $password = $passwordGen();
        $secret->setValue($password);
        $permit = $form->get('permit');
        $deny = $form->get('deny');
        $permit->setValue(self::SIP_NEWEXTEN_DEFAULT_PERMIT);
        $deny->setValue(self::SIP_NEWEXTEN_DEFAULT_DENY);
    }
    public function generateAction()
    {
        return new JsonModel(
            array(
                'pwd'=>$this->getPasswordGen()->__invoke()                
        )
            );       
    }
    protected function getExtensionForm()
    {
        if (!$this->extensionForm)
        {
            $this->extensionForm = $this->getServiceLocator()
            							->get('Vpbxui\Extension\Form\ExtensionForm');
        }
        return $this->extensionForm;
    }
    protected function populateCallDestinationFieldset($id)
    {
    	$form = $this->getExtensionForm();
    	$numbers = $form->get('numbers');
    	$callDestinations = $form->callDestinationTable
    	->fetchAll(array('peerid' => $id));
    	$destinations = array();
    	foreach ($callDestinations as $callDestination)
    	{
    		$callDestinationArray = (array)$callDestination;
    		$callDestinationArray['duration'] = (string)$callDestinationArray['duration'];
    		$destinations[] = $callDestinationArray;
    	}
    	$numbers->populateValues($destinations);
    	 
    	foreach ($numbers as $number)
    	{
    		$number->get('duration')->setAttribute('data-slider-value',$number->get('duration')->getValue());
    	
    	}    	     	 
    }
    protected function saveCallDestinations($id, $form)
    {
    	$formdata = $form->getData();
    	if (is_array($formdata))
    	{
     		$numbers = array();
    		foreach ($formdata['numbers'] as $callDestinationRec)
    		{
    			$callDestination = new CallDestination;    			 
    			$callDestination->exchangeArray($callDestinationRec);    			 
    			$numbers[]=$callDestination;
    		}    		
     	}
    	else 
    	{
    		$numbers = $formdata->numbers;
    	}     
      	$callDestinationTable = $this->getServiceLocator()->get('Vpbxui\CallDestination\Model\CallDestinationTable');
    	$callDestinationTable->deleteCallDestinations($id);
    	if ($numbers)
    	{
    		foreach ($numbers as $number)
    		{
    			$number->peerid = $id;
    			$callDestinationTable->SaveCallDestination($number);
    		}    	 
    	}
    }
}
