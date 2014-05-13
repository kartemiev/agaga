<?php
namespace PbxAgi\OperatorStatusLog\Model;

use PbxAgi\OperatorStatusLog\Model\OperatorStatusLogTableInterface;
use PbxAgi\OperatorStatusLog\Model\OperatorStatusLogInterface;
use Zend\Db\TableGateway\TableGatewayInterface;

class OperatorStatusLogTable implements OperatorStatusLogTableInterface
{
      protected $tableGateway;
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function addEntry(OperatorStatusLogInterface $operatorStatusLog)
    {
     
    	$data = array(   
             'extension' => $operatorStatusLog->extension,
             'operatorstatus' => $operatorStatusLog->operatorstatus
      	);
      	$this->tableGateway->insert($data);
    }    
}