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
    
    public function fetchAll($filter=null,$limit=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select,$limit) {
     $select->order('ext ASC');
   //  $select->limit($limit);
    });
            $resultSet->buffer();

    	return $resultSet;
    }
}
