<?php
namespace PbxAgi\ExtensionGroup\Model;

use Zend\Db\TableGateway\TableGateway;
 
class ExtensionGroupTable implements ExtensionGroupTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }   
    
    public function getExtensionGroup($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();    
     	return $row;
    }
   
}
