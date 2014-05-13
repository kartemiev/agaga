<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InternalProfileController extends AbstractActionController
{
    protected  $extensionProfileTable;
    protected $query = array();
    protected $filters = array();
    

      public function indexAction()
    {
      
        $extensionprofiles =  $this->getExtensionProfileTable()->fetchAll();      
          
         return new ViewModel(array(
            'extensionprofiles' => $extensionprofiles,                      
        ));
    }
    
   public function addAction()
    {
        $sm = (method_exists($this->serviceLocator, 'getServiceLocator'))?$this->serviceLocator->getServiceLocator():$this->serviceLocator;
        $form = $sm->get('Vpbxui\ExtensionProfile\Form\ExtensionProfileForm');
        $form->get('submit')->setValue('Добавить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $sm = $this->serviceLocator;
            $extensionProfile = $sm->get('Vpbxui\ExtensionProfile\Model\ExtensionProfile');
            $form->setInputFilter($extensionProfile->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
               $extensionProfile->exchangeArray($form->getData());
                $this->getExtensionProfileTable()->saveExtensionProfile($extensionProfile);
                 return $this->redirect()->toRoute('vpbxui/settings/profile/internal',$this->getQuery());
            }
        }
        return array('form' => $form);
    }
	
 public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vpbxui/settings/profile/internal', array(
                'action' => 'add'
            ));
        }
        $extensionProfile = $this->getExtensionProfileTable()->getExtensionProfile($id);

        $sm = (method_exists($this->serviceLocator, 'getServiceLocator'))?$this->serviceLocator->getServiceLocator():$this->serviceLocator;
        $form = $sm->get('Vpbxui\ExtensionProfile\Form\ExtensionProfileForm');
        
        $form->bind($extensionProfile);
        $form->get('submit')->setAttribute('value', 'Сохранить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($extensionProfile->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getExtensionProfileTable()->saveExtensionProfile($form->getData());

                $this->flashMessenger()->addMessage('Настройки для '.$form->getData()->profilename.' сохранены');
                 
                return $this->redirect()->toRoute('vpbxui/settings/profile/internal',$this->getQuery());
            }
        }

        return array(
            'id' => $id,
            'form' => $form
         );
    }
	
 public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
     	if (!$id) {
    		return $this->redirect()->toRoute('vpbxui/settings/profile/internal',$this->getQuery());
    	}
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'Нет');
    
    		if ($del == 'Да') {
    			$id = (int) $request->getPost('id');
    			$extensionProfile = $this->getExtensionProfileTable()->getExtensionProfile($id);    			 
    			$this->getExtensionProfileTable()->deleteExtensionProfile($id);
    		}
    
    		// Redirect to list of albums
    		return $this->redirect()->toRoute('vpbxui/settings/profile/internal',$this->getQuery());
    	}
    
    	return array(
    			'id'    => $id,
    			'extensionprofile' => $this->getExtensionProfileTable()->getExtensionProfile($id)
    	);
    }
	public function getExtensionProfileTable() {
	    if (!$this->extensionProfileTable) {
	    	$sm = $this->getServiceLocator();
	    	$this->extensionProfileTable = $sm->get('Vpbxui\ExtensionProfile\Model\ExtensionProfileTable');
	    }
		return $this->extensionProfileTable;
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
