<?php
namespace Vpbxui\OperatorStatusLog\Model;

use Zend\Db\TableGateway\TableGateway;
use Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTableInterface;
use Vpbxui\OperatorStatusLog\Model\OperatorStatusLog;

class OperatorStatusLogTable implements OperatorStatusLogTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function addEntry(OperatorStatusLog $logentry)
    {
    
        $data = array(
            'extension' => $logentry->extension,
            'operatorstatus' => $logentry->operatorstatus
         );
         $this->tableGateway->insert($data);
    }    
}