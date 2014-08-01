<?php
namespace Saas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Saas\FreeDid\Model\FreeDidTable;
use Zend\Paginator\Paginator;
use Saas\Gizzle\ApiSelect;
use Saas\PickDid\Form\PickDidForm;
use Zend\View\Model\JsonModel;
use Saas\PickDid\Model\PickDid;
use Agaga\Entity\Did;
use Saas\VpbxEnv\Model\VpbxEnv;
use Zend\Session\Container as SessionContainer;


class PickDidController extends AbstractActionController
{
	protected $freeDidTable;
	protected $wizardSessionContainer;
	public function __construct(FreeDidTable $freeDidTable, SessionContainer $wizardSessionContainer)
	{
		$this->freeDidTable = $freeDidTable;
 		$this->wizardSessionContainer = $wizardSessionContainer;
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
 				$vpbxEnv = new VpbxEnv();
 				$vpbxEnv->outgoingtrunk_did = $did->id;
				$vpbxEnv->vpbx_name = '';
				$vpbxEnv->vpbx_description = '';
				$this->wizardSessionContainer->vpbxEnv = $vpbxEnv;
				$currentDate = new \DateTime();
				$did->reservationdate = $currentDate->format('Y-m-d H:i:s');;
				$reservationDate = clone $currentDate;
				$reservationDate->add(new \DateInterval("PT1H"));
				$did->reserveduntil = $reservationDate->format('Y-m-d H:i:s');;
			 
				$this->freeDidTable->saveDid($did);
				
				
				$this->flashMessenger()->addMessage('Успешно выделен номер '.$did->digits);
				return $this->redirect()->toRoute('wizard',array('action'=>'step2'));
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