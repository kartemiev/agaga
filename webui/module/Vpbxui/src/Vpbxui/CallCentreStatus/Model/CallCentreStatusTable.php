<?php
namespace Vpbxui\CallCentreStatus\Model;

use Zend\Db\TableGateway\TableGateway;
use Vpbxui\CallCentreStatus\Model\CallCentreStatusTableInterface;
use Zend\Db\Sql\Select;

class CallCentreStatusTable implements CallCentreStatusTableInterface
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