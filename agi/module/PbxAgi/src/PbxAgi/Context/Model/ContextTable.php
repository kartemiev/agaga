<?php
namespace PbxAgi\Context\Model;

use PbxAgi\Context\Model\ContextTableInterface;
use PbxAgi\Context\Model\Context;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ContextTable implements ContextTableInterface
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
		
	public function getContext($id)
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