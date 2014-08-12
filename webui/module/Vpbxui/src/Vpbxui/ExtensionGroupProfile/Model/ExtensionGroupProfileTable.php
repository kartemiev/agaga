<?php
namespace Vpbxui\ExtensionGroupProfile\Model;

use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfile;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTableInterface;
use Vpbxui\Service\VpbxidProvider\VpbxidProviderInterface;

class ExtensionGroupProfileTable implements ExtensionGroupProfileTableInterface {

    protected $tableGateway;
    protected $vpbxidProvider;
    public function __construct(TableGateway $tableGateway, VpbxidProviderInterface $vpbxidProvider)
    {
    	$this->tableGateway = $tableGateway;
    	$this->vpbxidProvider = $vpbxidProvider;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select($filter,function (Select $select) {
    	$this->vpbxidProvider->vpbxFilter($select);    		
      	$select->order('profilename ASC');     
    });
            $resultSet->buffer();

    	return $resultSet;
    }
    
    public function getExtensionGroupProfile($id)
    {
		$id  = (int) $id;
    	
    	$sql = $this->tableGateway->getSql();
    	$select = $sql->select();
    	$this->vpbxidProvider->vpbxFilter($select);    	 
     	 
    	$select->where->equalTo('id', $id);
    	  
    	$select->limit(1);
     	$rowset = $this->tableGateway->selectWith($select);
     	
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
    	$data['vpbxid'] = ($this->vpbxidProvider->isSuperuser())?$extensionGroup->vpbxid:$vpbxid;
    	$vpbxid = $this->vpbxidProvider->getVpbxId();
    	 
    	if ($id == 0) {
    		$data['vpbxid']=$vpbxid;    		
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getExtensionGroupProfile($id)) {
    			$this->tableGateway->update($data, array('id' => $id, 'vpbxid' => $vpbxid));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    }
    
    public function deleteExtensionGroupProfile($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    	$sql = $this->tableGateway->getSql();
    	$select = $sql->select();
    	$select->where->equalTo('id',$id);
    	$this->vpbxidProvider->vpbxFilter($select);
    	$this->tableGateway->delete(array('id' => $id));
    }
   
}
