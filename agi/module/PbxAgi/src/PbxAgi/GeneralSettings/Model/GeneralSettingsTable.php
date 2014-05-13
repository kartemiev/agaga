<?php
namespace PbxAgi\GeneralSettings\Model;

use Zend\Db\TableGateway\TableGateway;

class GeneralSettingsTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
       
    public function getSettings($virtualpbxid)
    {
     	$rowset = $this->tableGateway->select(array('vpbxid' => $virtualpbxid));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row");
    	}
     	return $row;
    }    
}
