<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Vpbxui\ExtensionGroupProfile\Form\ExtensionGroupProfileForm;
use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfile;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;

class InternalGroupProfileController extends AbstractActionController
{
    protected  $extensionProfileGroupTable;
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

        $extensionProfileGroups =  $this->getExtensionProfileGroupTable()->fetchAll($select);      
          return new ViewModel(array(
            'extensionprofilegroups' => $extensionProfileGroups
        ));
    }
    
   public function addAction()
    {
        $form = new ExtensionGroupProfileForm();
        $form->get('submit')->setValue('Добавить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $extensionProfileGroup = new ExtensionGroupProfile();
            $form->setInputFilter($extensionProfileGroup->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
               $extensionProfileGroup->exchangeArray($form->getData());
                $this->getExtensionProfileGroupTable()->saveExtensionGroupProfile($extensionProfileGroup);
                // Redirect to list of albums
                return $this->redirect()->toRoute('vpbxui/settings/profile/group',$this->getQuery());
            }
        }
        return array('form' => $form);
    }
	
    
    
    
 public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vpbxui/settings/profile/group', array(
                'action' => 'add'
            ));
        }
        $extensionGroupProfile = $this->getExtensionProfileGroupTable()->getExtensionGroupProfile($id);

        $form  = new ExtensionGroupProfileForm();
        $form->bind($extensionGroupProfile);
        $form->get('submit')->setAttribute('value', 'Сохранить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($extensionGroupProfile->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getExtensionProfileGroupTable()->saveExtensionGroupProfile($form->getData());
                // Redirect to list of albums
                return $this->redirect()->toRoute('vpbxui/settings/profile/group',$this->getQuery());
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
	
 public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
     	if (!$id) {
    		return $this->redirect()->toRoute('vpbxui/settings/profile/group',$this->getQuery());
    	}
    	
    	
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'Нет');
    
    		if ($del == 'Да') {
    			$id = (int) $request->getPost('id');
    		  			 
    			$this->getExtensionProfileGroupTable()->deleteExtensionGroupProfile($id);
    		}
    
    		// Redirect to list of albums
    		return $this->redirect()->toRoute('vpbxui/settings/profile/group',$this->getQuery());
    	}
    	$extensionGroupProfile = $this->getExtensionProfileGroupTable()
    	->getExtensionGroupProfile($id);
    	
    
    	return array(
    			'id'    => $id,
    			'extensiongroupprofile' => $extensionGroupProfile
    	);
    }
	protected function getExtensionProfileGroupTable() {
	    if (!$this->extensionGroupProfileTable) {
	    	$sm = $this->getServiceLocator();
	    	$this->extensionGroupProfileTable = $sm->get('Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTable');
	    }
		return $this->extensionGroupProfileTable;
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
