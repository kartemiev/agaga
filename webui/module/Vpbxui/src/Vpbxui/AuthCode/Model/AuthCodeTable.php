<?php
namespace Vpbxui\AuthCode\Model;

use Zend\Db\TableGateway\TableGateway;
use Vpbxui\AuthCode\Model\AuthCode;
use Vpbxui\AuthCode\Model\AuthCodeTableInterface;
use Zend\Db\Sql\Select;

class AuthCodeTable implements AuthCodeTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getAuthCodeById($id)
    {
    	$id = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id, ''));
    	 
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     
    	return $row;    	
    }
    
    public function fetchAll($filter = NULL, $orderseq = NULL)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter,$orderseq) {
    		if (null!=$filter)
    		{
    			$select->where($filter);
    		}
    		if (null!=$orderseq)
    		{
    			$select->order($orderseq);
    		}
    	});
    	$resultSet->buffer();
    
    	return $resultSet;
    }
   public function saveAuthCode(AuthCode $authCode)
    {
        
    	$data = array(
    		'pincode' => $authCode->pincode
        	);
     
    	$id = (int)$authCode->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getAuthCodeById($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
     }
   public function deleteAuthCode($id)
     {
     	$this->tableGateway->delete(array('id' => $id));
     }   
    
}