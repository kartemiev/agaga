<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\Context\Model\Context;

class ContextController extends AbstractActionController
{	
	protected $contextTable;
	protected $contextForm;
	protected $trunkAssocTable;
	public function indexAction()
	{
		$contexts =  $this->getContextTable()
							  ->fetchAll();
		return new ViewModel(array(
				'contexts' => $contexts
		));
	}
	
	public function addAction()
	{
 		$form = $this->getContextForm();
		$form->get('submit')->setValue('Добавить');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$context = $this->getContext();
			$form->setInputFilter($context->getInputFilter());
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$formdata = $form->getData();								
				$context->exchangeArray($formdata);				
				$lastId = $this->getContextTable()->saveContext($context);				 
				$this->saveTrunkAssoc((int)$lastId);
 				return $this->redirect()->toRoute('vpbxui/settings/context');
			}
		}
 		return array('form' => $form);
	}
		
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('vpbxui/settings/context', array(
					'action' => 'add'
			));
		}
		$context = $this->getContextTable()->getContext($id);
	
		$form  = $this->getContextForm();
		$form->bind($context);
		$form->get('submit')->setAttribute('value', 'Сохранить');	
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$inputFilter = $context->getInputFilter();
  			$form->setInputFilter($inputFilter);
			$form->setData($request->getPost());	
			if ($form->isValid()) {
				$formdata = $form->getData();
				$this->getContextTable()->saveContext($formdata);
				$this->saveTrunkAssoc($formdata->id);
				return $this->redirect()->toRoute('vpbxui/settings/context');
			}
		}
		else 
		{
		    $this->populateTrunkFieldset($id);
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
			return $this->redirect()->toRoute('vpbxui/settings/context');
		}
		 		 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Нет');
	
			if ($del == 'Да') {
				$id = (int) $request->getPost('id');
	
				$this->getContextTable()->deleteContext($id);
			}
	
			// Redirect to list of albums
			return $this->redirect()->toRoute('vpbxui/settings/context');
		}
		$context = $this->getContextTable()
		->getContext($id);
		 
	
		return array(
				'id'    => $id,
				'context' => $context
		);
	}
	protected function getContextTable()
	{
	    if (!$this->contextTable)
	    {
	        $this->contextTable = $this->getServiceLocator()
	        							  ->get('Vpbxui\Context\Model\ContextTable');
	    }
	    return $this->contextTable;
	}		 
	
	protected function populateTrunkFieldset($id)
	{
		$form = $this->getContextForm();
		$trunks = $form->get('trunks');
		$trunkAssocResultset = $this->getTrunkAssocTable()
									->fetchAll(array('contextref' => $id));
		$trunkArray = array();
		foreach ($trunkAssocResultset as $trunkassoc)
		{
			$trunkAssocArray = (array)$trunkassoc;
			$trunkArray[] = $trunkAssocArray;
		}
		$trunks->populateValues($trunkArray);	
	}
	protected function getContextForm()
	{
	    if (!$this->contextForm)
	    {
	        $this->contextForm = $this->getServiceLocator()->get('Vpbxui\Context\Form\ContextForm');
	    }
	    return $this->contextForm;
	}
	protected function getTrunkAssocTable()
	{
	    if (!$this->trunkAssocTable)
	    {
	        $this->trunkAssocTable = $this->getServiceLocator()->get('Vpbxui\TrunkAssoc\Model\TrunkAssocTable');
	    }
	    return $this->trunkAssocTable;
	}
	protected function saveTrunkAssoc($id) /* one-to-many */
	{		
		$formdata = $this->getContextForm()->getData();
 		$trunks = $formdata['trunks'];
	 
		$trunkAssocTable = $this->getTrunkAssocTable();
 		$trunkAssocTable->deleteTrunkAssocByContext($id); 	 
		if ($trunks)
		{
			foreach ($trunks as $trunk)
			{
				$trunk->contextref = $id;
				$trunkAssocTable->saveTrunkAssoc($trunk);
			}
		}
	}
	
	protected function getContext()
	{
	    return $this->getServiceLocator()->get('Vpbxui\Context\Model\Context');
	}
}