<?php
namespace Vpbxui\ExtensionProfile\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ExtensionProfileTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
     $select->order('profilename ASC');
    });
            $resultSet->buffer();

    	return $resultSet;
    }
    
  
    
    public function getExtensionProfile($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
   
    
    public function saveExtensionProfile(ExtensionProfile $extensionProfile)
    {
        
    	$data = array(     
            'profilename' => $extensionProfile->profilename,
    		'profiledesc' => $extensionProfile->profiledesc,    			 
    	    'extensiontype' => $extensionProfile->extensiontype,
    	    'extensionrecord' => $extensionProfile->extensionrecord,
    	    'extensiongroup' => $extensionProfile->extensiongroup,
    	    'namedpickupgroup' => $extensionProfile->namedpickupgroup,
    	    'namedcallgroup' => $extensionProfile->namedcallgroup,    	    	
    	    'outgoingcallspermission' => $extensionProfile->outgoingcallspermission,
    	    'transfer' => $extensionProfile->transfer,
    	    'statuschange' => $extensionProfile->statuschange,
    	    'incoming' => $extensionProfile->incoming,
    	    'hold' => $extensionProfile->hold,
    	    'forwarding' => $extensionProfile->forwarding,
    	);
    	$id = (int)$extensionProfile->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getExtensionProfile($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    }
    
    public function deleteExtensionProfile($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
}
