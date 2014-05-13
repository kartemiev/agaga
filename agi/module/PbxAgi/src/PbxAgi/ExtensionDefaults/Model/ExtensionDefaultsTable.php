<?php
namespace PbxAgi\ExtensionDefaults\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ExtensionDefaultsTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
         
    public function getExtensionDefaults($vpbxid)
    {
    	$vpbxid  = (int) $vpbxid;
    	$rowset = $this->tableGateway->select(array('vpbxid' => $vpbxid));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $vpbxid");
    	}
     	return $row;
    }
     
  
}
