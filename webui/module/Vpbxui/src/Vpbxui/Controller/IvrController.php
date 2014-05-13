<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\Ivr\Form\IvrForm;
use Vpbxui\Ivr\Model\Ivr;

class IvrController extends AbstractActionController
{	
	protected $ivrTable;
	public function indexAction()
	{
		$ivrs =  $this->getIvrTable()
							  ->fetchAll();
		return new ViewModel(array(
				'ivrs' => $ivrs
		));
	}
	
	public function addAction()
	{
		$form = new IvrForm();
		$form->get('submit')->setValue('Добавить');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$ivr = new Ivr();
			$form->setInputFilter($ivr->getInputFilter());
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$ivr->exchangeArray($form->getData());
				$this->getIvrTable()->saveIvr($ivr);
 				return $this->redirect()->toRoute('vpbxui/settings/ivr');
			}
		}
		return array('form' => $form);
	}
		
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('vpbxui/settings/ivr', array(
					'action' => 'add'
			));
		}
		$ivr = $this->getIvrTable()->getIvr($id);
	
		$form  = new IvrForm();
		$form->bind($ivr);
		$form->get('submit')->setAttribute('value', 'Сохранить');	
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$inputFilter = $ivr->getInputFilter();
 			$form->setInputFilter($inputFilter);
			$form->setData($request->getPost());	
			if ($form->isValid()) {
				$this->getIvrTable()->saveIvr($form->getData());
				return $this->redirect()->toRoute('vpbxui/settings/ivr');
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
			return $this->redirect()->toRoute('vpbxui/settings/ivr');
		}
		 		 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Нет');
	
			if ($del == 'Да') {
				$id = (int) $request->getPost('id');
	
				$this->getIvrTable()->deleteIvr($id);
			}
	
			// Redirect to list of albums
			return $this->redirect()->toRoute('vpbxui/settings/ivr');
		}
		$ivr = $this->getIvrTable()
						   ->getIvr($id);
		 
	
		return array(
				'id'    => $id,
				'ivr' => $ivr
		);
	}
	protected function getIvrTable()
	{
	    if (!$this->ivrTable)
	    {
	        $this->ivrTable = $this->getServiceLocator()
	        					   ->get('Vpbxui\Ivr\Model\IvrTable');
	    }
	    return $this->ivrTable;
	}	
}