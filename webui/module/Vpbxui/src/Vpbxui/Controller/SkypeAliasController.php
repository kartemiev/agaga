<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\SkypeAlias\Form\SkypeAliasForm;
 
class SkypeAliasController extends AbstractActionController
{	
	protected $skypeAliasTable;
	public function indexAction()
	{
		$skypealiases =  $this->getSkypeAliasTable()
							  ->fetchAll();
		return new ViewModel(array(
				'skypealiases' => $skypealiases
		));
	}
	
	public function addAction()
	{
		$form = new SkypeAliasForm();
		$form->get('submit')->setValue('Добавить');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$skypealias = $this->getServiceLocator()
							   ->get('Vpbxui\SkypeAlias\Model\SkypeAlias');
			$form->setInputFilter($skypealias->getInputFilter());
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$skypealias->exchangeArray($form->getData());
				$this->getSkypeAliasTable()->saveSkypeAlias($skypealias);
 				return $this->redirect()->toRoute('vpbxui/settings/skypealias');
			}
		}
		return array('form' => $form);
	}
		
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('vpbxui/settings/skypealias', array(
					'action' => 'add'
			));
		}
		$skypealias = $this->getSkypeAliasTable()->getSkypeAlias($id);
	
		$form  = new SkypeAliasForm();
		$form->bind($skypealias);
		$form->get('submit')->setAttribute('value', 'Сохранить');	
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$inputFilter = $skypealias->getInputFilter();
			$this->injectNoRecordExistsValidatorCurrentNumberExclude($inputFilter, $skypealias->number);			
 			$form->setInputFilter($inputFilter);
			$form->setData($request->getPost());	
			if ($form->isValid()) {
				$this->getSkypeAliasTable()->saveSkypeAlias($form->getData());
				return $this->redirect()->toRoute('vpbxui/settings/skypealias');
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
			return $this->redirect()->toRoute('vpbxui/settings/skypealias');
		}
		 		 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Нет');
	
			if ($del == 'Да') {
				$id = (int) $request->getPost('id');
	
				$this->getSkypeAliasTable()->deleteSkypeAlias($id);
			}
	
			// Redirect to list of albums
			return $this->redirect()->toRoute('vpbxui/settings/skypealias');
		}
		$skypealias = $this->getSkypeAliasTable()
		->getSkypeAlias($id);
		 
	
		return array(
				'id'    => $id,
				'skypealias' => $skypealias
		);
	}
	protected function getSkypeAliasTable()
	{
	    if (!$this->skypeAliasTable)
	    {
	        $this->skypeAliasTable = $this->getServiceLocator()
	        							  ->get('Vpbxui\SkypeAlias\Model\SkypeAliasTable');
	    }
	    return $this->skypeAliasTable;
	}	
	protected function injectNoRecordExistsValidatorCurrentNumberExclude($inputFilter, $number)
	{
		$validators = $inputFilter->get('number')
								  ->getValidatorChain()
								  ->getValidators();
		foreach ($validators as $validator)
		{
			$instance = $validator['instance'];
			if ($instance instanceof \Zend\Validator\Db\NoRecordExists)
			{
				$instance->setExclude( array(
						'field' => 'number',
						'value' => $number
				));				
			}
		}
	}
}