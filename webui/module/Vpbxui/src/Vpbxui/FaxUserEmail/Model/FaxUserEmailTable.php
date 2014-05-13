<?php
namespace Vpbxui\FaxUserEmail\Model;

use Vpbxui\FaxUserEmail\Model\FaxUserEmail;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Vpbxui\FaxUserEmail\Model\FaxUserEmailTableInterface;

class FaxUserEmailTable implements FaxUserEmailTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
          
    public function getFaxUserEmailsByFaxUserId($userref)
    {
    	$userref  = (int) $userref;
    	$resultSet = $this->tableGateway->select(array('userref' => $userref));    	 
     	return $resultSet;
    }
     
    public function saveFaxUserEmail(FaxUserEmail $faxuseremail)
    {
        
    	$data = array(
    		'userref' => $faxuseremail->userref,
    	    'email' => $faxuseremail->email,  
        	);
          	 
    	$this->tableGateway->insert($data);             
    }
    
    public function deleteFaxUserEmails($userref)
    {
    	$this->tableGateway->delete(array('userref' => $userref));
    }   
}
