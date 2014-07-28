<?php
namespace Did\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Did\FreeDid\Model\FreeDidTable;
use Zend\Paginator\Paginator;
use Did\Gizzle\ApiSelect;
use Did\PickDid\Form\PickDidForm;
use Zend\View\Model\JsonModel;

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
 		
		return new ViewModel(
				array('dids'=>$dids,
						'page'=>$page,
						'form'=>$form
 				)
		);
		return new ViewModel();
	}
	public function modelAction()
	{
		$page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 99999999;
		$itemsPerPage = 20;
		
		$apiGateway = $this->freeDidTable->getApiGateway();
		
		$one = microtime();
		$dids  = $this->freeDidTable->fetchAll(array('offset'=>1,'limit'=>$itemsPerPage));
		shuffle($dids);
		
		
		return new JsonModel(
				array('dids'=>$dids
				)
		);
	}
}