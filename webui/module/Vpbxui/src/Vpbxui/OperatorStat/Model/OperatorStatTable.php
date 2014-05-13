<?php
namespace Vpbxui\OperatorStat\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Vpbxui\OperatorStat\Model\OperatorStatTableInterface;

class OperatorStatTable implements OperatorStatTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
          	$resultSet = $this->tableGateway->select($filter,function (Select $select) {
    });
            $resultSet->buffer();

    	return $resultSet;
    }     
}