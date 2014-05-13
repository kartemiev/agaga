<?php

namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;
use Vpbxui\PickupGroup\Model\PickupGroup;
use Vpbxui\PickupGroup\Form\PickupGroupForm;

/**
 * ExtensionGroupController
 * 
 * @author
 * @version 
 */
class PickupGroupController extends AbstractActionController {
    protected  $pickupGroupTable;
    protected $query = array();
    protected $filters = array();
    

        public function indexAction()
    {
       $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'name';
        $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        
        $select = new Select();
        $select->order($order_by . ' ' . $order);

        $pickupGroups =  $this->getPickupGroupTable()->fetchAll($select);      

         return new ViewModel(array(
            'filters'   => $this->getFilters(),
            'pickupgroups' => $pickupGroups,
                'order_by' => $order_by,
                    'order' => $order,
        ));
    }
    
   public function addAction()
    {
        $form = new PickupGroupForm();
        $form->get('submit')->setValue('Добавить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $pickupGroup = new PickupGroup();
            $form->setInputFilter($pickupGroup->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
               $pickupGroup->exchangeArray($form->getData());
                $this->getPickupGroupTable()->savePickupGroup($pickupGroup);
                // Redirect to list of albums
                return $this->redirect()->toRoute('vpbxui/settings/groups/pickup',$this->getQuery());
            }
        }
        return array('form' => $form);
    }
	
 public function editAction()
    {
        $name = (int) $this->params()->fromRoute('name', 0);
        if (!$name) {
            return $this->redirect()->toRoute('vpbxui/settings/groups/pickup', array(
                'action' => 'add'
            ));
        }
        $pickupGroup = $this->getPickupGroupTable()->getPickupGroup($name);

        $form  = new PickupGroupForm();
        $form->bind($pickupGroup);
        $form->get('submit')->setAttribute('value', 'Сохранить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($pickupGroup->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getPickupGroupTable()->savePickupGroup($form->getData());
                // Redirect to list of albums
                return $this->redirect()->toRoute('vpbxui/settings/groups/pickup',$this->getQuery());
            }
        }

        return array(
            'name' => $name,
            'form' => $form,
        );
    }
	
 public function deleteAction()
    {
    	$name = (int) $this->params()->fromRoute('name', 0);
     	if (!$name) {
    		return $this->redirect()->toRoute('vpbxui/settings/groups/pickup',$this->getQuery());
    	}
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'Нет');
    
    		if ($del == 'Да') {
    			$name = $request->getPost('name');
    			$pickupGroup = $this->getPickupGroupTable()->getPickupGroup($name);    			 
    			$this->getPickupGroupTable()->deletePickupGroup($name);
     		}
    
    		// Redirect to list of albums
    		return $this->redirect()->toRoute('vpbxui/settings/groups/pickup',$this->getQuery());
    	}
    
    	return array(
    			'name'    => $name,
    			'pickupgroup' => $this->getPickupGroupTable()->getPickupGroup($name)
    	);
    }
	public function getPickupGroupTable() {
	    if (!$this->pickupGroupTable) {
	    	$sm = $this->getServiceLocator();
	    	$this->pickupGroupTable = $sm->get('Vpbxui\PickupGroup\Model\PickupGroupTable');
	    }
		return $this->pickupGroupTable;
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
