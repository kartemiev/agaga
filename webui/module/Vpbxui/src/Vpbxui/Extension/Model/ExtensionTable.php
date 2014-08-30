<?php
namespace Vpbxui\Extension\Model;

use Vpbxui\Extension\Model\Extension;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Vpbxui\Extension\Model\ExtensionTableInterface;
 
 
class ExtensionTable implements ExtensionTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
    		$select->where->equalTo('peertype','EXTENSION');
    		$select->order('extension ASC');    		
     		});
    		 
         $resultSet->buffer();
 		
    	return $resultSet;
    }
    
    public function fetchDistinctExtensions($limit)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->order('extension ASC');
            if (NULL!==$limit)
            {
                $select->limit($limit);
            }
            $select->columns(array(new Expression('DISTINCT(extension) as extension')));

            $sql = $this->tableGateway->getSql();
            
        });
            $resultSet->buffer();
            
        return $resultSet;
    }
 
    public function getNextFreeExtension()
    {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->order('extension ASC')->limit(1);
            $select->columns(array(new Expression('DISTINCT(extension) as extension')));
        });
        $resultSet->buffer();
    
        return $resultSet;
    }
    
    public function getExtension($id)
    {
    	$id  = (int) $id;
    	
    	$sql = $this->tableGateway->getSql();
    	$select = $sql->select();
     	 
    	$select->where->equalTo('id', $id)->AND->equalTo('peertype','EXTENSION');
    	  
    	$select->limit(1);
     	$rowset = $this->tableGateway->selectWith($select);
     	
//		var_dump($sql->getSqlstringForSqlObject($select));     	 
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
   
    
    public function saveExtension(Extension $extension)
    {
        
    	$data = array(
    		'name' => $extension->name,
    	    'extension' => $extension->extension,   
            'callerid' => $extension->callerid,
    		'secret'  => $extension->secret,
    	    'custname' => $extension->custname,
    	    'custdesc' => $extension->custdesc,
            'extensiontype' => $extension->extensiontype,
    	    'extensionrecord' => $extension->extensionrecord,
    	    'extensiongroup' => $extension->extensiongroup,
    	    'namedpickupgroup' => $extension->namedpickupgroup,
    	    'namedcallgroup' => $extension->namedcallgroup,    	    	
    	    'outgoingcallspermission' => $extension->outgoingcallspermission,
    	    'transfer' => $extension->transfer,
    	    'statuschange' => $extension->statuschange,
    	    'incoming' => $extension->incoming,
    	    'hold' => $extension->hold,
    	    'forwarding' => $extension->forwarding,
    	    'deny' => $extension->deny,
    	    'permit' => $extension->permit,
    	    'email' => $extension->email,    	 
    		'callsequence' => $extension->callsequence,    			 
    		'diversion_unconditional_status' => $extension->diversion_unconditional_status,
    		'diversion_unconditional_number' => $extension->diversion_unconditional_number,
    		'diversion_unavail_status' => $extension->diversion_unavail_status,
    		'diversion_unavail_number' => $extension->diversion_unavail_number,
    		'diversion_busy_status' => $extension->diversion_busy_status,
    		'diversion_busy_number' => $extension->diversion_busy_number,
    		'diversion_noanswer_status' => $extension->diversion_noanswer_status,
    		'diversion_noanswer_number' => $extension->diversion_noanswer_number,
    		'defaultuser' => $extension->defaultuser,    			 
    		'number_status' => $extension->number_status,   
    		'diversion_unconditional_landingtype' => $extension->diversion_unconditional_landingtype,
    		'diversion_unavail_landingtype' => $extension->diversion_unavail_landingtype,
    		'diversion_busy_landingtype' => $extension->diversion_busy_landingtype,
    		'diversion_noanswer_landingtype' => $extension->diversion_noanswer_landingtype,   
    		'diversion_noanswer_duration' => $extension->diversion_noanswer_duration,
    		'extensionrecord' => $extension->extensionrecord,
    		'busylevel' => $extension->busylevel
        	);
     
    	$data['routeref']=($extension->routeref)?$extension->routeref:null;
     
    	
     	$id = (int)$extension->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getExtension($id)) {
    			$filter = array('id'=>$id,'peertype'=>'EXTENSION');   		
     			$this->tableGateway->update($data,$filter);
     			
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
    public function deleteExtension($id)
    {
    	$sql = $this->tableGateway->getSql();
    	$select = $sql->select();
    	$select->where->equalTo('id',$id)
    			->AND->equalTo('peertype', 'EXTENSION');
    	$this->tableGateway->delete(array('id' => $id));
    }
    public function getOperatorList()
    {
       	$resultSet = $this->tableGateway->select(function (Select $select)  {
     		$select->where->equalTo('extensiontype','operator');
       		$select->order('extension ASC');
     });
 
    	return $resultSet;
    }    
 }
