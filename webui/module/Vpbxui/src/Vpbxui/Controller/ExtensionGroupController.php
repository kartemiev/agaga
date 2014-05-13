<?php

namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Vpbxui\ExtensionGroup\Form\ExtensionGroupForm;
use Vpbxui\ExtensionGroup\Model\ExtensionGroup;

/**
 * ExtensionGroupController
 * 
 * @author
 * @version 
 */
class ExtensionGroupController extends AbstractActionController {
    protected $extensionGroupTable;
    protected $extensionGroupProfileTable;
    protected $query = array();
    protected $filters = array();
    

        public function indexAction()
    {
       $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
       $itemsPerPage = 20;
        
       $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        
        $select = new Select();
        $select->order($order_by . ' ' . $order);

        $extensionGroups =  $this->getExtensionGroupTable()->fetchAll($select);      
        $paginator = new Paginator(new paginatorIterator($extensionGroups));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);
 
        

         return new ViewModel(array(
            'filters'   => $this->getFilters(),
            'extensiongroups' => $extensionGroups,
                    'page' => $page,
                    'paginator' => $paginator,
                'order_by' => $order_by,
                    'order' => $order,
        ));
    }
    
 public function addAction()
    {        
       
        $sm = (method_exists($this->serviceLocator, 'getServiceLocator'))?$this->serviceLocator->getServiceLocator():$this->serviceLocator;
        $form = new ExtensionGroupForm();
        $form->get('submit')->setValue('Добавить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $sm = $this->serviceLocator;
            $extensiongroup = new ExtensionGroup();
            $form->setInputFilter($extensiongroup->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
             
               $extensiongroup->exchangeArray($form->getData());
                $this->getExtensionGroupTable()->saveExtensionGroup($extensiongroup);
                 return $this->redirect()->toRoute('vpbxui/settings/groups/internal',$this->getQuery());
            }
             
        }
        else 
        {
            $profile = $this->params('id');
            if (!$profile)
            {
                $this->redirect()->toRoute('vpbxui/settings/groups/internal', array('action' => 'profile'));
            }
            $profile = (int)$profile;
            $extensionGroupProfileTable = $this->getExtensionGroupProfileTable();
            $extensionGroupProfile = $extensionGroupProfileTable->getExtensionGroupProfile($profile);
            unset($extensionGroupProfile->id);
            $form->bind($extensionGroupProfile);            
        }        
        $this
        ->getServiceLocator()
        ->get('viewhelpermanager')
        ->get('HeadScript')
        ->appendFile('/js/bootstrap-slider.js')
        ;
        $headLink = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
        $headLink->appendStylesheet('/css/slider.css');
         return array('form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages(),     
         );
    }
	
    public function profileAction()
    {
        $sm = (method_exists($this->serviceLocator, 'getServiceLocator'))?$this->serviceLocator->getServiceLocator():$this->serviceLocator;
        $form = $sm->get('Vpbxui\ExtensionGroup\Form\ExtensionGroupProfilePickerForm');
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $sm = $this->serviceLocator;
            $extensiongroupprofile = $sm->get('Vpbxui\ExtensionGroup\Model\ExtensionGroupProfilePicker');
            $form->setInputFilter($extensiongroupprofile->getInputFilter());
            $form->setData($request->getPost());
    
            if ($form->isValid()) {
                $extensiongroupprofile->exchangeArray($form->getData());
                $extensionGroupProfileTable = $this->getExtensionGroupProfileTable();
                $extensionGroupProfileRecord = $extensionGroupProfileTable->getExtensionGroupProfile($extensiongroupprofile->profile);
                $groupProfileName = $extensionGroupProfileRecord->profilename;
                $this->flashMessenger()->addMessage('Загружены настройки профиля группы "'.$groupProfileName.'"');
                return $this->redirect()->toRoute('vpbxui/settings/groups/internal',
                    array('action'=>'add','id' => $extensiongroupprofile->profile));
            }
        }
        return array('form' => $form);
    }
        
    
 public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vpbxui/settings/groups/internal', array(
                'action' => 'add'
            ));
        }
        $extensionGroup = $this->getExtensionGroupTable()->getExtensionGroup($id);

        $form  = new ExtensionGroupForm();
        $form->bind($extensionGroup);
        $form->get('submit')->setAttribute('value', 'Сохранить');

        $element = $form->get('diversion_noanswer_duration');
        $element->setAttribute('data-slider-value', $element->getValue());
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($extensionGroup->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getExtensionGroupTable()->saveExtensionGroup($form->getData());
                // Redirect to list of albums
                return $this->redirect()->toRoute('vpbxui/settings/groups/internal',$this->getQuery());
            }
        }
        $this
        ->getServiceLocator()
        ->get('viewhelpermanager')
        ->get('HeadScript')
        ->appendFile('/js/bootstrap-slider.js')
        ;
        $headLink = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
        $headLink->appendStylesheet('/css/slider.css');
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
	
 public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
     	if (!$id) {
    		return $this->redirect()->toRoute('vpbxui/settings/groups/internal',$this->getQuery());
    	}
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'Нет');
    
    		if ($del == 'Да') {
    			$id = (int) $request->getPost('id');
    			$extensionGroup = $this->getExtensionGroupTable()->getExtensionGroup($id);    			 
    			$this->getExtensionGroupTable()->deleteExtensionGroup($id);
    		}
    
    		// Redirect to list of albums
    		return $this->redirect()->toRoute('vpbxui/settings/groups/internal',$this->getQuery());
    	}
    
    	return array(
    			'id'    => $id,
    			'extensiongroup' => $this->getExtensionGroupTable()->getExtensionGroup($id)
    	);
    }
    
     
	public function getExtensionGroupTable() {
	    if (!$this->extensionGroupTable) {
	    	$sm = $this->getServiceLocator();
	    	$this->extensionGroupTable = $sm->get('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable');
	    }
		return $this->extensionGroupTable;
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
    
    protected function getExtensionGroupProfileTable()
    {
        if (!$this->extensionGroupProfileTable) {
            $sm = $this->getServiceLocator();
            $this->extensionGroupProfileTable = $sm->get('Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTable');
        }
        return $this->extensionGroupProfileTable;
    
    }
    
}
