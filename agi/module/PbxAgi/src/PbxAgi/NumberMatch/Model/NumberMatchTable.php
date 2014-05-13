<?php
namespace PbxAgi\NumberMatch\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use PbxAgi\NumberMatch\Model\NumberMatch;

class NumberMatchTable implements NumberMatchTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null,$orderseq=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter,$orderseq){
            $select->where($filter);
     });
            $resultSet->buffer();

    	return $resultSet;
    }
    
     public function getNumberMatch($id)
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
