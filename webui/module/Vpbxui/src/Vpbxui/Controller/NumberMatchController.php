<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\NumberMatch\Model\NumberMatch;
use Vpbxui\NumberMatch\Form\NumberMatchForm;

class NumberMatchController extends AbstractActionController
{	
 
	protected $numberMatchTable;
	protected $numberMatchForm;
	protected $regEntryTable;
	public function indexAction()
	{
		$numbermatches =  $this->getNumberMatchTable()
						->fetchAll();
		return new ViewModel(array(
				'numbermatches' => $numbermatches
		));
	}
	
	public function addAction()
	{
 		$form = $this->getNumberMatchForm();
		$form->get('submit')->setValue('Добавить');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$numbermatch = new NumberMatch();
			$form->setInputFilter($numbermatch->getInputFilter());
			$form->setData($request->getPost());
   			if ($form->isValid()) {
				$formdata = $form->getData();						 
				$numbermatch->exchangeArray($formdata);				
 		 
				$lastId = $this->getNumberMatchTable()
							  ->saveNumberMatch($numbermatch);	
				$this->saveRegEntries((int)$lastId);				
 				return $this->redirect()->toRoute('vpbxui/settings/filter');
			}
		}
 		return array('form' => $form);
	}
		
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('vpbxui/settings/filter', array(
					'action' => 'add'
			));
		}
		$numbermatch = $this->getNumberMatchTable()
					  		->getNumberMatch($id);
	
		$form  = $this->getNumberMatchForm();
		$form->bind($numbermatch);
		$form->get('submit')->setAttribute('value', 'Сохранить');	
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$inputFilter = $numbermatch->getInputFilter();
  			$form->setInputFilter($inputFilter);
			$form->setData($request->getPost());	
			if ($form->isValid()) {
				$formdata = $form->getData();
				$this->getNumberMatchTable()->saveNumberMatch($formdata);
				$this->saveRegEntries($formdata->id);				
				return $this->redirect()->toRoute('vpbxui/settings/filter');
			}
		}
		else 
		{
			$this->populateRegEntryFieldset($id);
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
			return $this->redirect()->toRoute('vpbxui/settings/filter');
		}
		 		 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Нет');
	
			if ($del == 'Да') {
				$id = (int) $request->getPost('id');
	
				$this->getNumberMatchTable()
				     ->deleteNumberMatch($id);
			}
	
			return $this->redirect()->toRoute('vpbxui/settings/filter');
		}
		$numbermatch = $this->getNumberMatchTable()
							->getNumberMatch($id);
		 
	
		return array(
				'id'    => $id,
				'numbermatch' => $numbermatch
		);
	}
	protected function getNumberMatchTable()
	{
		if (!$this->numberMatchTable)
		{
		    $this->numberMatchTable = $this->getServiceLocator()->get('Vpbxui\NumberMatch\Model\NumberMatchTable');
		}
	    return $this->numberMatchTable;
	}
	protected function getNumberMatchForm()
	{
	    if (!$this->numberMatchForm)
	    {
	        $this->numberMatchForm = new NumberMatchForm();
	    }
	    return $this->numberMatchForm;
	}
 	protected function getRegEntryTable()
	{
	    if (!$this->regEntryTable)
	    {
	        $this->regEntryTable = $this->getServiceLocator()
	        							->get('Vpbxui\RegEntry\Model\RegEntryTable');
	    }
	    return $this->regEntryTable;
	}
	protected function populateRegEntryFieldset($numbermatchid)
	{
		$form = $this->getNumberMatchForm();
		$regentries = $form->get('regentries');
	 
		$regEntryResultset = $this->getRegEntryTable()
									->fetchAll(array('numbermatchref' => $numbermatchid));
		$regEntryArr = array();
		foreach ($regEntryResultset as $regentry)
		{
			$regEntryArr[] = (array)$regentry;
		}
		
 
		
		$regentries->populateValues($regEntryArr);
	}	
	
	protected function saveRegEntries($numbermatchid) /* one-to-many */
	{
		$formdata = $this->getNumberMatchForm()
						 ->getData();
		$regentries = $formdata->regentries;
 
		$regEntryTable = $this->getRegEntryTable();
		$regEntryTable->deleteRegEntryByNumberMatch($numbermatchid);
		if ($regentries)
		{
			foreach ($regentries as $regentry)
			{
				$regentry->numbermatchref = $numbermatchid;
				$regEntryTable->saveRegEntry($regentry);
			}
		}
	}
}