<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\Trunk\Form\TrunkForm;
use Vpbxui\Trunk\Model\Trunk;
 
class TrunkController extends AbstractActionController
{	
	protected $trunkTable;
	public function indexAction()
	{
		$registryCommand = $this->getServiceLocator()->get('Vpbxui\Registry\Model\RegistryCommand');
		$registrations = $registryCommand->fetchAll();
		$trunks =  $this->getTrunkTable()
							  ->fetchAll();
 		$trunkregistrations = array();
		/*
		 * warning warning - below code is highly unoptimised for performance (slow!) - TBD
		 */
	 
		foreach ($trunks as $trunkkey=>$trunk)
		{		 
			$trunkregistration = array();
			$trunkregistration['trunk'] = $trunk;
			foreach ($registrations as $registrationkey=>$registration)
			{
		     	if (($trunk->host==$registration->host)&&($trunk->defaultuser==$registration->username))
		     	{
		     	    $trunkregistration['registration'] =  $registration;
		     	    unset($registrations[$registrationkey]);
		     	    break;
		     	}		     	 
			}
			$trunkregistrations[] = $trunkregistration;
		}
		$viewHelperManager = $this->getServiceLocator()
								  ->get('viewhelpermanager')
								  ->get('HeadScript')
								  ->appendFile('/js/trunk.js');
		
  		$viewModel = new ViewModel(array(
				'trunkregistrations' => $trunkregistrations
		));
  		$request = $this->getRequest();
  		$viewModel->setTerminal($request->isXmlHttpRequest());
  		return $viewModel;
	}
	
	public function addAction()
	{
		$form = new TrunkForm();		
		$form->get('submit')->setValue('Добавить');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$trunk = new Trunk();			
  			$form->setInputFilter($trunk->getInputFilter());
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$trunk->exchangeArray($form->getData());
				$lastId = $this->getTrunkTable()->saveTrunk($trunk);
				$trunk->callbackextension = $lastId;
				$trunk->id = $lastId;
				$trunk->defaultuser = $trunk->name;
				$lastId = $this->getTrunkTable()->saveTrunk($trunk);
				
				$this->sipReload();
  				return $this->redirect()->toRoute('vpbxui/settings/trunk');
			}
		} else
		{
		    $trunk = new Trunk();
		    $trunk->insecure = 'port,invite';
		    $form->setData($trunk->getArrayCopy());	
		}		
		
		return array('form' => $form);
	}
		
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('vpbxui/settings/trunk', array(
					'action' => 'add'
			));
		}
		$trunk = $this->getTrunkTable()->getTrunk($id);
	
		$form  = new TrunkForm();
		$form->bind($trunk);
		$form->get('submit')->setAttribute('value', 'Сохранить');	
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$inputFilter = $trunk->getInputFilter();
			$form->setInputFilter($inputFilter);
		 
			$form->setData($request->getPost());	
	 
			if ($form->isValid()) {
			 	$formdata = $form->getData();
 			 	$formdata->defaultuser = $formdata->name;
				$this->getTrunkTable()->saveTrunk($formdata);
				$this->sipReload();				
				return $this->redirect()->toRoute('vpbxui/settings/trunk');
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
			return $this->redirect()->toRoute('vpbxui/settings/trunk');
		}
		$trunk = $this->getTrunkTable()
		->getTrunk($id);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Нет');
	
			if ($del == 'Да') {
				$id = (int) $request->getPost('id');	
				$this->getTrunkTable()->deleteTrunk($id);
				$this->sipReload();				
			}
	
			// Redirect to list of albums
			return $this->redirect()->toRoute('vpbxui/settings/trunk');
		}
		  
	
		return array(
				'id'    => $id,
				'trunk' => $trunk
		);
	}
	protected function getTrunkTable()
	{
	    if (!$this->trunkTable)
	    {
	        $this->trunkTable = $this->getServiceLocator()
	        							  ->get('Vpbxui\Trunk\Model\TrunkTable');
	    }
	    return $this->trunkTable;
	}	
	protected function sipReload()
	{
		$pruneCommand = $this->getServiceLocator()
							 ->get('Vpbxui\Reload\Model\ReloadCommand');
		$pruneCommand->sipReload();
		return $this;
	}	
}