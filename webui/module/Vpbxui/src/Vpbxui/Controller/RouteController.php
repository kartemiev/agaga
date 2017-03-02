<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\Route\Model\Route;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Vpbxui\TrunkDestination\Model\TrunkDestination;
 
class RouteController extends AbstractActionController
{	
 
	protected $routeTable;
	protected $trunkDestinationTable;
	protected $routeForm;
	public function indexAction()
	{
		$routes =  $this->getRouteTable()
						->fetchAll();
		return new ViewModel(array(
				'routes' => $routes
		));
	}
	
	public function addAction()
	{
 		$form = $this->getRouteForm();
		$form->get('submit')->setValue('Добавить');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$route = new Route();
			$form->setInputFilter($route->getInputFilter());
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$formdata = $form->getData();			 					
				$route->exchangeArray($formdata);				
				$this->resetDefaultFields($route);
				$lastId = $this->getRouteTable()->saveRoute($route);		 
				$this->saveTrunkDestinations((int)$lastId);				 
 				return $this->redirect()->toRoute('vpbxui/settings/route');
			}
		}
 		return array('form' => $form);
	}
		
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('vpbxui/settings/route', array(
					'action' => 'add'
			));
		}
		$route = $this->getRouteTable()->getRoute($id);
	
		$form  = $this->getRouteForm();
		$form->bind($route);
		$form->get('submit')->setAttribute('value', 'Сохранить');	
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$inputFilter = $route->getInputFilter();
  			$form->setInputFilter($inputFilter);
			$form->setData($request->getPost());	
			if ($form->isValid()) {
				$formdata = $form->getData();
				$this->resetDefaultFields($formdata);				
				$this->getRouteTable()->saveRoute($formdata);
 				$this->saveTrunkDestinations($id);
				return $this->redirect()->toRoute('vpbxui/settings/route');
			}
		}
		else 
		{
		    $this->populateTrunkDestinationFieldset($id);
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
			return $this->redirect()->toRoute('vpbxui/settings/route');
		}
		 		 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Нет');
	
			if ($del == 'Да') {
				$id = (int) $request->getPost('id');
	
				$this->getRouteTable()->deleteRoute($id);
			}
	
			return $this->redirect()->toRoute('vpbxui/settings/route');
		}
		$route = $this->getRouteTable()
						->getRoute($id);
		 
	
		return array(
				'id'    => $id,
				'route' => $route
		);
	}
	protected function getRouteTable()
	{
		if (!$this->routeTable)
		{
		    $this->routeTable = $this->getServiceLocator()->get('Vpbxui\Route\Model\RouteTable');
		}
	    return $this->routeTable;
	}
	protected function getRouteForm()
	{
		if (!$this->routeForm)
		{
			$this->routeForm = $this->getServiceLocator()->get('Vpbxui\Route\Form\RouteForm');		
		}
		return $this->routeForm;
	}
	public function getTrunkDestinationTable()
	{
	    if (!$this->trunkDestinationTable)
	    {
	        $this->trunkDestinationTable = $this->getServiceLocator()
	        									->get('Vpbxui\TrunkDestination\Model\TrunkDestinationTable');
  	    }
	    return $this->trunkDestinationTable;
	}
	protected function populateTrunkDestinationFieldset($routeid)
	{
		$form = $this->getRouteForm();
		$destinations = $form->get('destinations');
		$trunkDestinationResultset = $this->getTrunkDestinationTable()
								  		  ->fetchAll(array('routeref' => $routeid));
 
		$trunkDestinationArr = array();
		foreach ($trunkDestinationResultset as $trunkdestination)
		{
			$trunkDestinationArr[] = (array)$trunkdestination;
		}
 		$destinations->populateValues($trunkDestinationArr);
	}
	
	protected function saveTrunkDestinations($routeid) /* one-to-many */
	{
		$formdata = $this->getRouteForm()
						 ->getData();
 
		$trunkdestinations =  $formdata['destinations'];
	 
		
		$trunkDestinationTable = $this->getTrunkDestinationTable();
		$trunkDestinationTable->deleteTrunkDestinationAll($routeid);

 
		if ($trunkdestinations)
		{
			foreach ($trunkdestinations as $trunkdestination)
			{
				$trunkdestination['routeref'] = $routeid;
				$hydrator = new ObjectProperty();
				$object = new TrunkDestination();
				$object = $hydrator->hydrate($trunkdestination, $object);				
				$trunkDestinationTable->saveTrunkDestination($object);
			}
		}
	}
	protected function resetDefaultFields(Route $route)
	{
	    if ($route->isdefault)
	    {
	        $this->getRouteTable()
	        	 ->updateDefaultFileldsResetDefault();
	    }	    
	}	
}