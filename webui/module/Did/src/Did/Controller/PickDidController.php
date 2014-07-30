<?php
namespace Did\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Did\FreeDid\Model\FreeDidTable;
use Zend\Paginator\Paginator;
use Did\Gizzle\ApiSelect;
use Did\PickDid\Form\PickDidForm;
use Zend\View\Model\JsonModel;
use Did\PickDid\Model\PickDid;
use Agaga\Entity\Did;

class PickDidController extends AbstractActionController
{
	protected $freeDidTable;
	public function __construct(FreeDidTable $freeDidTable)
	{
		$this->freeDidTable = $freeDidTable;
	}
	public function indexAction()
	{
		$form = new PickDidForm();		
		$request = $this->getRequest();
		$pickDid = new PickDid();
		
		if ($request->isPost()) {
			$inputFilter = $pickDid->getInputFilter();
			$form->setInputFilter($inputFilter);
			$form->bind($pickDid);
			$form->setData($request->getPost());
			if ($form->isValid()) {
				
				$did = $this->freeDidTable->getDid($pickDid->id);				
				
				if (!$did)
				{
					$this->flashMessenger()->addMessage('Извините, выбранный номер был уже занят - показаны другие номера');						
					return $this->redirect()->toRoute('pickdid');						
				}
				
				
			}
		}
		 		
		return new ViewModel(
				array(
						'page'=>$page,
						'form'=>$form,
						'flashMessages'=>$this->flashMessenger()->getMessages()
 				)
		);
		return new ViewModel();
	}
	public function modelAction()
	{
		$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 99999999;
		$itemsPerPage = $this->params()->fromQuery('limit') ? (int) $this->params()->fromQuery('limit') : 10;
		
		$apiGateway = $this->freeDidTable->getApiGateway();
		
		$one = microtime();
		$resultSet  = $this->freeDidTable->fetchAll(array('offset'=>1,'limit'=>$itemsPerPage));
		$dids = array();
		foreach ($resultSet as $did)
		{
			$dids[]=$did->getArrayCopy();
		}
		
		return new JsonModel(
				array('dids'=>$dids
				)
		);
	}
}