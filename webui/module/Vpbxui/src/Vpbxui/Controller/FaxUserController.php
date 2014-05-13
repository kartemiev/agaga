<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\FaxUser\Model\FaxUser;
use Vpbxui\FaxUser\Form\FaxUserForm;
use Vpbxui\FaxUserEmail\Model\FaxUserEmail;
use Vpbxui\FaxUserEmail\Model\FaxUserEmailTable;
use Vpbxui\FaxUser\Model\FaxUserTable;

class FaxUserController extends AbstractActionController
{	
 
	protected $faxUserTable;
	protected $faxUserForm;
	protected $faxUserEmailTable;
	public function __construct(
			FaxUserEmailTable $faxUserEmailTable, 
			FaxUserTable $faxUserTable
		)
	{
		$this->faxUserEmailTable = $faxUserEmailTable;
		$this->faxUserTable = $faxUserTable;
	}
	
	public function indexAction()
	{
		$faxusers =  $this->faxUserTable;
		
 		return new ViewModel(array(
				'faxusers' => $faxusers
		));
	}
	
	public function addAction()
	{
 		$form = $this->getFaxUserForm();
		$form->get('submit')->setValue('Добавить');
	
		$request = $this->getRequest();
		if ($request->isPost()) {
			$faxuser = new FaxUser();
			$form->setInputFilter($faxuser->getInputFilter());
			$form->setData($request->getPost());
   			if ($form->isValid()) {
				$formdata = $form->getData();						 
				$faxuser->exchangeArray($formdata);				
 		 
				$lastId = $this->faxUserTable
							    ->saveFaxUser($faxuser);	
				$this->saveFaxUserEmails((int)$lastId);				
 				return $this->redirect()->toRoute('vpbxui/settings/faxuser');
			}
		}
 		return array('form' => $form);
	}
		
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('vpbxui/settings/faxuser', array(
					'action' => 'add'
			));
		}
		$faxuser = $this->faxUserTable
					  		->getFaxUser($id);
	
		$form  = $this->getFaxUserForm();
		$form->bind($faxuser);
		$form->get('submit')->setAttribute('value', 'Сохранить');	
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$inputFilter = $faxuser->getInputFilter();
  			$form->setInputFilter($inputFilter);
			$form->setData($request->getPost());	
			if ($form->isValid()) {
				$formdata = $form->getData();
				$this->faxUserTable
					 ->saveFaxUser($formdata);
				$this->saveFaxUserEmails($formdata->id);				
				return $this->redirect()->toRoute('vpbxui/settings/faxuser');
			}
		}
		else 
		{
			$this->populateFaxUserEmailsFieldset($id);
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
			return $this->redirect()->toRoute('vpbxui/settings/faxuser');
		}
		 		 
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'Нет');
	
			if ($del == 'Да') {
				$id = (int) $request->getPost('id');
	
				$this->faxUserTable
				     ->deleteFaxUser($id);
			}
	
			return $this->redirect()->toRoute('vpbxui/settings/faxuser');
		}
		$faxuser = $this->faxUserTable
							->getFaxUser($id);
		 
	
		return array(
				'id'    => $id,
				'faxuser' => $faxuser
		);
	}
	protected function getFaxUserForm()
	{
	    if (!$this->faxUserForm)
	    {
	        $this->faxUserForm = new FaxUserForm;
	    }
	    return $this->faxUserForm;
	}
	protected function populateFaxUserEmailsFieldset($faxuserid)
	{
		$form = $this->getFaxUserForm();
		$emails = $form->get('emails');
	 
		$emailResultSet = $this->faxUserEmailTable
									->getFaxUserEmailsByFaxUserId($faxuserid);
		$emailArr = array();
 		
		foreach ($emailResultSet as $email)
		{
 			$emailArr[] = (array)$email;
		}
 				
		$emails->populateValues($emailArr);
	}	
	
	protected function saveFaxUserEmails($faxuserid) /* one-to-many */
	{
		$formdata = $this->getFaxUserForm()
						 ->getData();

		if (is_array($formdata))
		{
			$emails = array();
			foreach ($formdata['emails'] as $emailRec)
			{
				$faxUserEmail = new FaxUserEmail();
				$$faxUserEmail->exchangeArray($emailRec);
				$emails[]=$faxUserEmail;
			}
		}
		else
		{
			$emails = $formdata->emails;
		}
		
		$faxUserEmailTable = $this->faxUserEmailTable;
		$faxUserEmailTable->deleteFaxUserEmails($faxuserid);
		if ($emails)
		{
			foreach ($emails as $email)
			{
				$email->userref = $faxuserid;
				$faxUserEmailTable->saveFaxUserEmail($faxuserid);
			}
		}
	}
}