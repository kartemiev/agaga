<?php
namespace PbxAgi\Ivr\Model;

use PbxAgi\Ivr\Model\IvrTableInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class IvrTable implements IvrTableInterface
{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll($filter = null, $limit = null)
	{
	    return $this->tableGateway->select(function(Select $select) use ($filter, $limit){
	        	$select->where($filter)
	        		   ->limit($limit);
	    	}
		);
	    
	}	 
	public function getIvr($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}	 
}