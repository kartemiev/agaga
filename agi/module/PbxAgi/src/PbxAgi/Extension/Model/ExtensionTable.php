<?php
namespace PbxAgi\Extension\Model;

use Zend\Db\TableGateway\TableGateway;
use PbxAgi\Extension\Model\ExtensionTableInterface;
use PbxAgi\Extension\Model\Extension;
use Zend\Db\Sql\Select;

class ExtensionTable implements ExtensionTableInterface
{

    protected $tableGateway;

    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
    }
    public function fetchAll($filter = null, $limit = null)
    {
      
    	return $this->tableGateway->select(function(Select $select) use ($filter, $limit){
        	$select->where($filter)
        	->limit($limit);
        });
     }
    public function getExtension($extension)
    {
        $extension = (int) $extension;
        $rowset = $this->tableGateway->select(array(
            'extension' => $extension, 'peertype'=>'EXTENSION'
        ));
        $row = $rowset->current();
        if (! $row) {
            return null; 
        }
        return $row;
    }
    public function getExtensionById($id)
    {
    	$id = (int) $id;
    	$rowset = $this->tableGateway->select(array('id'=>$id));
    	$row = $rowset->current();
    	if (! $row) {
    		return null;  
    	}
    	return $row;
    }
    
    public function updateExtensionUnconditionalForward(Extension $extension)
    {        
    	$data = array(            
    	    'diversion_unconditional_number' => $extension->diversion_unconditional_number,
    	    'diversion_unconditional_status' => $extension->diversion_unconditional_status  
    	);
    	$extension = $extension->extension;
     	$this->tableGateway->update($data, array('extension' => $extension));
    }    
        public function getFaxExtension()
        {
        $rowset = $this->tableGateway->select(array(
            'faxextension' => true
        ));
        $row = $rowset->current();
        if (! $row) {
            return null; // throw new Exception; // доделать по нормальному
        }
        return $row;            
        }
    public function isValid($extension)
    {
        $extension = (int) $extension;
        $rowset = $this->tableGateway->select(array(
            'extension' => $extension, 'peertype'=>'EXTENSION'
        ));
        $rowcount = $rowset->count();
        if (1>$rowcount) {
            return false; // throw new Exception; // доделать по нормальному
        }
         return true;
    }
}