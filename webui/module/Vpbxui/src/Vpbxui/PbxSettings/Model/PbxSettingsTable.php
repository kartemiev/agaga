<?php
namespace Vpbxui\PbxSettings\Model;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\PbxSettings\Model\PbxSettingsTableInterface;
use Vpbxui\PbxSettings\Model\PbxSettings;
use Vpbxui\Service\VpbxidProvider\VpbxidProviderInterface;
use Zend\Crypt\PublicKey\Rsa\PublicKey;

class PbxSettingsTable implements PbxSettingsTableInterface
{
    protected $tableGateway;
    protected $vpbxidProvider;
    public function __construct(TableGateway $tableGateway, VpbxidProviderInterface $vpbxidProvider)
    {
        $this->tableGateway = $tableGateway;
        $this->vpbxidProvider = $vpbxidProvider;
    }
    
    public function fetchAll($filter = null)
    {        
        if (!$filter) $filter = array();
        $filter['vpbxid'] = ($filter['vpbxid'])?$filter['vpbxid']:1;
        $resultSet = $this->tableGateway->select($filter);
        return $resultSet;
    }       

    public function getPbxSettings($vpbxid)
    {
    	$vpbxid  = (int) $vpbxid;
    	
    	$sql = $this->tableGateway->getSql();
    	$select = $sql->select();
    	$this->vpbxidProvider->vpbxFilter($select);    	 
     	 
    	$select->where->equalTo('vpbxid', $vpbxid);
    	  
    	$select->limit(1);
     	$rowset = $this->tableGateway->selectWith($select);

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
    		$vpbxid = $this->vpbxidProvider->getVpbxId();    		
    		$data['vpbxid'] = ($this->vpbxidProvider->isSuperuser())?$pbxsettings->vpbxid:$vpbxid;    		
    		if ($this->getPbxSettings($vpbxid)) {
     			$this->tableGateway->update($data,array('vpbxid'=>$vpbxid));
     			
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
}