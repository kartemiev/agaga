<?php
namespace Vpbxui\Trunk\Model;

use Vpbxui\Trunk\Model\Trunk;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Vpbxui\Trunk\Model\TrunkTableInterface;

class TrunkTable implements TrunkTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
     		$select->order('id ASC');
     		$select->where(array('peertype'=>'TRUNK'));     		 
    	});
    	return $resultSet;
    }
    
      public function getTrunk($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id, 'peertype'=>'TRUNK'));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
        
    public function deleteAllTrunks()
    {
        $this->tableGateway->delete(array('peertype'=>'TRUNK'));        
    }
    public function saveTrunk(Trunk $trunk)
    {
        
    	$data = array(
    		'name' => $trunk->name,    			 
    		'secret' => $trunk->secret,
    		'custname' => $trunk->custname,    			
    		'callerid' => $trunk->callerid,
    		'host' => $trunk->host,
    		'callbackextension' => $trunk->callbackextension,
     		'insecure' => $trunk->insecure,
    		'custdesc' => $trunk->custdesc,
    		'peertype' => 'TRUNK',  
    		'context' => 'vpbx_trunks',
    		'defaultuser' => $trunk->defaultuser,
    		'port' => $trunk->port,    			 
      	);
    
    	$id = (int)$trunk->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	 
    	} else {
    		if ($this->getTrunk($id)) {
    			$this->tableGateway->update($data, array('id' => $id, 'peertype'=>'TRUNK'));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
   
    public function deleteTrunk($id)
    {
    	$this->tableGateway->delete(array('id' => $id, 'peertype'=>'TRUNK'));
    }
    protected function getFilter($originalfilter = array())
    {
        return array_merge($originalfilter,array('extensiontype'=>''));
    }
}
