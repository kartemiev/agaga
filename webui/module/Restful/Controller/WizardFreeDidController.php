<?php
namespace Restful\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Saas\FreeDid\Model\FreeDidTableInterface;
class WizardFreeDidController extends AbstractRestfulController
{
	protected $freeDidTable;
	public function __construct(FreeDidTableInterface $freeDidTable)
	{
		$this->freeDidTable = $freeDidTable;
	}
	public function getList()
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