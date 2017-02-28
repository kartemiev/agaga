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
use Zend\Mvc\MvcEvent;
use Vpbxui\ExtensionGroup\Model\ExtensionGroupTable;
use Vpbxui\ExtensionProfile\Model\ExtensionProfileTable;
use Vpbxui\Extension\Model\ExtensionProfilePicker;
use Zend\Navigation\Navigation;
use Vpbxui\Prune\Model\PruneCommand;
use Vpbxui\Service\PasswordGen\PasswordGen;
use Vpbxui\FreeExtension\Model\FreeExtensionTable;
use Vpbxui\Extension\Form\ExtensionForm;  
use Vpbxui\CallDestination\Model\CallDestinationTable;
use Vpbxui\DefaultDenyPermit\Model\DefaultDenyPermitTable;
use Vpbxui\Extension\Model\Extension;
use Vpbxui\Extension\Form\ExtensionProfilePickerForm;
 
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
    private $extension;
    private $extensionProfilePicker;
    private $extensionProfilePickerForm;
    private $navigation;
    private $pruneCommand;
    private $callDestinationTable;
    private $defaultDenyPermitTable;
    const SIP_DEFAULT_NUM_LINES = 30;
    public function __construct(
        ExtensionTableInterface $extensionTable,   
        ExtensionGroupTable $extensionGroupTable, 
        ExtensionProfileTable $extensionProfileTable, 
        OperatorStatusLogTableInterface $operatorStatusLogTable,
        Extension $extension,
        ExtensionProfilePicker $extensionProfilePicker,
        Navigation $navigation,
        PruneCommand $pruneCommand,
        PasswordGen $passwordGen,
        FreeExtensionTable $freeExtensionTable,
        ExtensionForm $extensionForm,
        CallDestinationTable $callDestinationTable,
        DefaultDenyPermitTable $defaultDenyPermitTable,
        ExtensionProfilePickerForm $extensionProfilePickerForm
        )
    {
        $this->extensionTable = $extensionTable;
        $this->extensionGroupTable = $extensionGroupTable;
        $this->extensionProfileTable = $extensionProfileTable;
        $this->operatorStatusLogTable = $operatorStatusLogTable;
        $this->extension = $extension;
        $this->extensionProfilePicker = $extensionProfilePicker;
        $this->extensionProfilePickerForm = $extensionProfilePickerForm;
        $this->navigation = $navigation;
        $this->pruneCommand = $pruneCommand;
        $this->passwordGen = $passwordGen;
        $this->freeExtensionTable = $freeExtensionTable;
        $this->extensionForm = $extensionForm;
        $this->callDestinationTable = $callDestinationTable;
        $this->defaultDenyPermitTable = $defaultDenyPermitTable;
        $this->extensionProfilePickerForm = $extensionProfilePickerForm;
    }
    public function indexAction()
    {
        $select = new Select();
        $select->order('extension ASC');

        $extensions =  $this->extensionTable->fetchAll($select); 
        $extensionGroups = $this->extensionGroupTable->fetchAll();
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
        $form = $this->extensionForm;
        $form->get('actions')
        ->get('submit')
        ->setLabel('Добавить');
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $extension = $this->extension;
            $form->setInputFilter($extension->getInputFilter());
            $form->setData($request->getPost());            
            if ($form->isValid()) {
               $extension->exchangeArray($form->getData());          
			
                $id = (int)$this->extensionTable->saveExtension($extension);  
                
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
            $extensionProfileTable = $this->extensionProfileTable;
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
        $form = $this->extensionProfilePickerForm;
        $request = $this->getRequest();
        if ($request->isPost()) {
             $extensionprofile = $this->extensionProfilePicker;
            $form->setInputFilter($extensionprofile->getInputFilter());
            $form->setData($request->getPost());
             if ($form->isValid()) {            	 
               $extensionprofile->exchangeArray($form->getData());
               $extensionProfileTable = $this->extensionProfileTable;

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
        $extension = $this->extensionTable->getExtension($id);

//        $navigation = $this->getServiceLocator()->get('Navigation');
        $navigation = $this->navigation;
        $page = $navigation->findBy('id', 'internal'.($extension->id));
        $page->setActive();
        
        $form = $this->extensionForm;
        
        $form->bind($extension);
         $form->get('actions')
        ->get('submit')
        ->setLabel('Сохранить');
         
         $element = $form->get('diversion_noanswer_duration');
         $element->setAttribute('data-slider-value', $element->getValue());
        
        $extensionElement = $form->get('extension');
        $extensionElement->setAttribute('disabled', 'disabled');
                
        $options = $extensionElement->getValueOptions();
        $options[$extension->extension] = $extension->extension;
        ksort($options, SORT_NUMERIC);
        
        $extensionElement->setAttribute('options', $options);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($extension->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->extensionTable->saveExtension($form->getData());
                $this->saveCallDestinations($id, $form);
                $peerName = $form->getData()->name;
                 $this->prunePeer($peerName);
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
    			$extension = $this->extensionTable->getExtension($id);    			 
    			$this->extensionTable->deleteExtension($id);
                         $peerName = $extension->name;
                         if (ExtensionTableInterface::EXTENSION_TYPE_OPERATOR == $extension->extensiontype)
                         {
                            $this->addOperatorStatusLogEntry($extension->extension, 
                             OperatorStatusLogTableInterface::OPERATORSTATUS_DELETED);
                         }
                        $this->prunePeer($peerName);
    		}
    
    		return $this->redirect()->toRoute('vpbxui/internal',$this->getQuery());
    	}
    
    	return array(
    			'id'    => $id,
    			'extension' => $this->extensionTable->getExtension($id)
    	);
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
        $this->pruneCommand->prunePeer($peername);
        return $this;
    }
    protected function addOperatorStatusLogEntry($extension, $operatorstatus)
    {
        $logEntry = new OperatorStatusLogEntry();
        $logEntry->extension = $extension;
        $logEntry->operatorstatus = $operatorstatus;
        $operatorStatusLogTable = $this->operatorStatusLogTable;
        $operatorStatusLogTable->addEntry($logEntry);        
    }
    protected function extensionAddSetDefaultFormValues($form)
    {
        $name = $form->get('name');
        $nextFreeExtensions = $this->freeExtensionTable->fetchAll();
        $nextFreeExtension = $nextFreeExtensions->current()->ext;
        $name->setValue($nextFreeExtension);
        
        $secret = $form->get('secret');
        $password = $this->passwordGen->__invoke();
        $secret->setValue($password);
        $permit = $form->get('permit');
        $deny = $form->get('deny');
        $defaultDenyPermit = $this->defaultDenyPermitTable->getDefaultDenyPermit();
        $permit->setValue($defaultDenyPermit->permit);
        $deny->setValue($defaultDenyPermit->deny);
    }
    public function generateAction()
    {
        return new JsonModel(
            array(
                'pwd'=>$this->passwordGen->__invoke()                
        )
            );       
    }
    protected function populateCallDestinationFieldset($id)
    {
    	$form = $this->extensionForm;
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
    	$this->callDestinationTable->deleteCallDestinations($id);
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
