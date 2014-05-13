<?php
namespace PbxAgi\CallDestination\Model;

use PbxAgi\CallDestination\Model\CallDestination;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CallDestinationTable
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter) {
    	$select->order('id ASC');
    	$select->where($filter);
    });
            $resultSet->buffer();

    	return $resultSet;
    }    
    public function deleteCallDestinations($peerid)
    {
        $this->tableGateway->delete(array('peerid'=>$peerid));
    }
    public function SaveCallDestination(CallDestination $calldestination)
    {
    	$data = array(
    			'peerid' => $calldestination->peerid,
    			'number' => $calldestination->number,
    			'duration' => $calldestination->duration,    			 
    	);
    	$this->tableGateway->insert($data);
    }
}