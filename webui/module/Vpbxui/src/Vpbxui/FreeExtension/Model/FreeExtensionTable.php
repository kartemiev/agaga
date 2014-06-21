<?php
namespace Vpbxui\FreeExtension\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
 
class FreeExtensionTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
     $select->order('ext ASC');
    });
            $resultSet->buffer();

    	return $resultSet;
    }
}
