<?php
namespace Vpbxui\ExtensionGroup\Model;

use Vpbxui\ExtensionGroup\Model\ExtensionGroup;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Vpbxui\Service\VpbxidProvider\VpbxidProviderInterface;

class ExtensionGroupTable {

    protected $tableGateway;
    protected $vpbxidProvider;
    public function __construct(TableGateway $tableGateway, VpbxidProviderInterface $vpbxidProvider)
    {
    	$this->tableGateway = $tableGateway;
    	$this->vpbxidProvider = $vpbxidProvider;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
    	$this->vpbxidProvider->vpbxFilter($select);
     	$select->order('name ASC');	
    });
            $resultSet->buffer();

    	return $resultSet;
    }
    
    public function getExtensionGroup($id)
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
    
   
    
    public function saveExtensionGroup(ExtensionGroup $extensionGroup)
    {
        
    	$data = array(
    	    'name' => $extensionGroup->name,  
    	    'transfer' => $extensionGroup->transfer,
    	    'statuschange' => $extensionGroup->statuschange,
    	    'incoming' => $extensionGroup->incoming,
    	    'memberofcallcentreque' => $extensionGroup->memberofcallcentreque,
    	    'hold' => $extensionGroup->hold,
    	    'forwarding' => $extensionGroup->forwarding,
    	    'custdesc' => $extensionGroup->custdesc,
    		'number_status' => $extensionGroup->number_status, 
    	    'diversion_unconditional_status' => $extensionGroup->diversion_unconditional_status,
    		'diversion_unconditional_number' => $extensionGroup->diversion_unconditional_number,
    		'diversion_unavail_status' => $extensionGroup->diversion_unavail_status,
    		'diversion_unavail_number' => $extensionGroup->diversion_unavail_number,
    		'diversion_busy_status' => $extensionGroup->diversion_busy_status,
    		'diversion_busy_number' => $extensionGroup->diversion_busy_number,
    		'diversion_noanswer_status' => $extensionGroup->diversion_noanswer_status,
    		'diversion_noanswer_number' => $extensionGroup->diversion_noanswer_number,
    		'diversion_unconditional_landingtype' => $extensionGroup->diversion_unconditional_landingtype,
    		'diversion_unavail_landingtype' => $extensionGroup->diversion_unavail_landingtype,
    		'diversion_busy_landingtype' => $extensionGroup->diversion_busy_landingtype,
    		'diversion_noanswer_landingtype' => $extensionGroup->diversion_noanswer_landingtype,
    		'diversion_noanswer_duration' => $extensionGroup->diversion_noanswer_duration,    			     			     			
    		'extensionrecord' => $extensionGroup->extensionrecord
    	);
    	$id = (int)$extensionGroup->id;
    	$vpbxid = $this->vpbxidProvider->getVpbxId();
    	$data['vpbxid'] = ($this->vpbxidProvider->isSuperuser())?$extensionGroup->vpbxid:$vpbxid;
    	 
    	if ($id == 0) {
    		$data['vpbxid']=$vpbxid;    		
    		$this->tableGateway->insert($data);
    	} else {
    		
    		if ($this->getExtensionGroup($id)) {
    			$this->tableGateway->update($data, array('id' => $id,'vpbxid'=>$vpbxid));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    }
    
    public function deleteExtensionGroup($id)
    {
		$sql = $this->tableGateway->getSql();
    	$select = $sql->select();
    	$select->where->equalTo('id',$id);
    	$this->vpbxidProvider->vpbxFilter($select);
    	$this->tableGateway->delete(array('id' => $id));    
    }   
}
