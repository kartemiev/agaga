<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Vpbxui\AuthCode\Model\AuthCodeTableInterface;
use Vpbxui\AuthCode\Form\AuthCodeForm;
use Vpbxui\AuthCode\Model\AuthCode;
use Zend\Db\Sql\Where;
 
 
class AuthCodeController extends AbstractActionController
{	
	protected $authCodeTable;
	public function __construct(AuthCodeTableInterface $authCodeTable)
	{
		$this->authCodeTable = $authCodeTable;
	}
 	public function indexAction()
	{
		$filter = new Where();
		$filter->equalTo('', $right);
		
		$authcodes =  $this->authCodeTable->fetchAll();
							 
		return new ViewModel(array(
				'authcodes' => $authcodes
		));
	}
	
	public function addAction()
	{
		$form = new AuthCodeForm();
		$form->get('submit')->setValue('Добавить');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$authcode = new AuthCode();
			$form->setInputFilter($authcode->getInputFilter());
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$authcode->exchangeArray($form->getData());
				$this->authCodeTable->saveSkypeAlias($skypealias);
 				return $this->redirect()->toRoute('vpbxui/settings/authcode');
			}
		}
		return array('form' => $form);
	}
		
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('vpbxui/settings/authcode', array(
					'action' => 'add'
			));
		}
		$authcode = $this->authCodeTable->getAuthCodeById($id);
	
		$form  = new AuthCodeForm();
		$form->bind($authcode);
		$form->get('submit')->setAttribute('value', 'Сохранить');	
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$inputFilter = $authcode->getInputFilter();
 			$form->setInputFilter($inputFilter);
			$form->setData($request->getPost());	
			if ($form->isValid()) {
				$this->authCodeTable->saveAuthCode($form->getData());
				return $this->redirect()->toRoute('vpbxui/settings/authcode');
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
			return $this->redirect()->toRoute('vpbxui/settings/authcode');
		}
		 		 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Нет');
	
			if ($del == 'Да') {
				$id = (int) $request->getPost('id');
	
				$this->authCodeTable->deleteAuthCode($id);
			}
	
			return $this->redirect()->toRoute('vpbxui/settings/authcode');
		}
		$authcode = $this->authCodeTable
						   ->getAuthCodeById($id);
		 
	
		return array(
				'id'    => $id,
				'authcode' => $authcode
		);
	}
}