<?php
namespace Vpbxui\PbxSettings\Model;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\PbxSettings\Model\PbxSettingsTableInterface;
use Vpbxui\PbxSettings\Model\PbxSettings;
use Zend\Db\Sql\Select;

class PbxSettingsTable implements PbxSettingsTableInterface
{
    protected $tableGateway;
    protected $vpbxidProvider;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
     }
    
    public function fetchAll($filter = null)
    {        
        if (!$filter) $filter = array();
         $resultSet = $this->tableGateway->select(function(Select $select) use ($filter){
             $select->where($filter);
         });
        return $resultSet;
    }       

    public function getPbxSettings($vpbxid)
    {
    	$vpbxid  = (int) $vpbxid;
    	
        
    	
     	$rowset = $this->tableGateway->select(array('vpbxid'=>$vpbxid));

     	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
 public function savePbxSettings(PbxSettings $pbxsettings)
    {
        
    	$data = array(
    		'callcentre_status_override' => $pbxsettings->callcentre_status_override,
        	);
         	
     	$vpbxid = (int)$pbxsettings->vpbxid;
    	if (0 ==$vpbxid) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
      		if ($this->getPbxSettings($vpbxid)) {
     			$this->tableGateway->update($data,array('vpbxid'=>$vpbxid));
     			
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
}