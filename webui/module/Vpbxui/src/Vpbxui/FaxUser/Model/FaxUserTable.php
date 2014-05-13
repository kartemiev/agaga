<?php
namespace Vpbxui\FaxUser\Model;

use Vpbxui\FaxUser\Model\FaxUser;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Vpbxui\FaxUser\Model\FaxUserTableInterface;

class FaxUserTable implements FaxUserTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
     		$select->order('custname ASC');
     		});
        $resultSet->buffer();

    	return $resultSet;
    }
    
  
    public function getFaxUser($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
   
    
    public function saveFaxUser(FaxUser $faxuser)
    {
        
    	$data = array(
    		'custname' => $faxuser->custname,
    	    'custdesc' => $faxuser->custdesc,  
    		'email' => $faxuser->email,    			 
        	);
     
     	$id = (int)$faxuser->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getExtension($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
    public function deleteFaxUser($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }   
}
