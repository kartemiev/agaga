<?php
namespace PbxAgi\Trunk\Model;

use PbxAgi\Trunk\Model\Trunk;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use PbxAgi\Trunk\Model\TrunkTableInterface;

class TrunkTable implements TrunkTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
     		$select->order('id ASC');
     		$select->where(array('peertype'=>'TRUNK'));     		 
    	});
    	return $resultSet;
    }
    
      public function getTrunk($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id, 'peertype'=>'TRUNK'));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    public function getTrunkByCallbackExten($callbackextension)
    {
    	$rowset = $this->tableGateway->select(array('callbackextension' => $callbackextension, 'peertype'=>'TRUNK'));
    	if ($rowset)
    	{
    		$row = $rowset->current();    	 
    	}
    	return $row;
    }
}
