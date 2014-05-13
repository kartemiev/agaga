<?php
namespace PbxAgi\TrunkAssoc\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class TrunkAssocTable implements TrunkAssocTableInterface
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
	public function getTrunkAssocByTrunkId($trunkid)
	{
		$trunkid  = (int) $trunkid;
		$rowset = $this->tableGateway->select(array('trunkref'=> $trunkid));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $trunkid");
		}
		return $row;
	}	 
}