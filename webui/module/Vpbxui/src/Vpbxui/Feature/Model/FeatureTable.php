<?php
namespace Vpbxui\Feature\Model;

use Vpbxui\Feature\Model\FeatureTableInterface;
use Vpbxui\Feature\Model\Feature;
use Zend\Db\TableGateway\TableGateway;

class FeatureTable implements FeatureTableInterface
{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAll($filter=null)
	{
		$resultSet = $this->tableGateway->select();	
		return $resultSet;
	}
	
	public function getFeature($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	 
	public function saveFeature(Feature $context)
	{
		throw new \Exception('not implemented');
 	}
	
	public function deleteFeature($id)
	{
		throw new \Exception('not implemented');
	}
}