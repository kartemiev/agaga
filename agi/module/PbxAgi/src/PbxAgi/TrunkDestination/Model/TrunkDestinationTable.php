<?php
namespace PbxAgi\TrunkDestination\Model;

use PbxAgi\TrunkDestination\Model\TrunkDestination;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use PbxAgi\TrunkDestination\Model\TrunkDestinationTableInterface;

class TrunkDestinationTable implements TrunkDestinationTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select($filter);
    	return $resultSet;
    }                 
}
