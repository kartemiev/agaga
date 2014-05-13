<?php

namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;



/**
 * UserRolesController
 * 
 * @author
 * @version 
 */
class UserRolesController extends AbstractActionController {
    protected  $userRoleTable;
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

        $userRoles =  $this->getUserRoleTable()
                                ->fetchAll($select);      
        $paginator = new Paginator(new paginatorIterator($userRoles));
        $paginator->setCurrentPageNumber($page)
                ->setItemCountPerPage($itemsPerPage)
                ->setPageRange(7);
 
        

         return new ViewModel(array(
            'filters'   => $this->getFilters(),
            'userroles' => $userRoles,
                    'page' => $page,
                    'paginator' => $paginator,
                'order_by' => $order_by,
                    'order' => $order,
        ));
    }
    
   
	
 public function editAction()
    {
        $user_id = (int) $this->params()->fromRoute('user_id', 0);
        if (!$user_id) {
            return $this->redirect()->toRoute('vpbxui/users/roles', array(
                'action' => 'add'
            ));
        }
        $userRole = $this->getUserRoleTable()->getUserRole($user_id);

        
        $sm = $this->getServiceLocator();
        $form  = $sm->get('Vpbxui\UserRole\Form\UserRoleForm');
        $form->bind($userRole);
        $form->get('submit')->setAttribute('value', 'Сохранить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($userRole->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUserRoleTable()->saveUserRole($form->getData());
                // Redirect to list of albums
                return $this->redirect()->toRoute('vpbxui/users/roles',$this->getQuery());
            }
        }

        return array(
            'user_id' => $user_id,
            'form' => $form,
        );
    }
	
  
	public function getUserRoleTable() {
	    if (!$this->userRoleTable) {
	    	$sm = $this->getServiceLocator();
	    	$this->userRoleTable = $sm->get('Vpbxui\UserRole\Model\UserRoleTable');
	    }
		return $this->userRoleTable;
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
