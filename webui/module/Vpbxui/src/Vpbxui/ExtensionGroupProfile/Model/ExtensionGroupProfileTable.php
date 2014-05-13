<?php
namespace Vpbxui\ExtensionGroupProfile\Model;

use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfile;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTableInterface;

class ExtensionGroupProfileTable implements ExtensionGroupProfileTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select($filter,function (Select $select) {
     $select->order('profilename ASC');
    });
            $resultSet->buffer();

    	return $resultSet;
    }
    
    public function getExtensionGroupProfile($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
   
    
    public function saveExtensionGroupProfile(ExtensionGroupProfile $extensionGroupProfile)
    {
        
    	$data = array(
    	    'profilename' => $extensionGroupProfile->profilename,  
    	    'profiledesc' => $extensionGroupProfile->profiledesc,    	    	
    	    'transfer' => $extensionGroupProfile->transfer,
    	    'statuschange' => $extensionGroupProfile->statuschange,
    	    'incoming' => $extensionGroupProfile->incoming,
    	    'memberofcallcentreque' => $extensionGroupProfile->memberofcallcentreque,
    	    'hold' => $extensionGroupProfile->hold,
    	    'forwarding' => $extensionGroupProfile->forwarding,
    	);
    	$id = (int)$extensionGroupProfile->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getExtensionGroupProfile($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    }
    
    public function deleteExtensionGroupProfile($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
   
}
