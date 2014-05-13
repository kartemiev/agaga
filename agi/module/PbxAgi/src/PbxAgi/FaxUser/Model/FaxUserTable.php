<?php
namespace PbxAgi\FaxUser\Model;

use PbxAgi\FaxUser\Model\FaxUser;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use PbxAgi\FaxUser\Model\FaxUserTableInterface;

class FaxUserTable implements FaxUserTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function getFaxUserByEmail($email)
    {
    	$rowset = $this->tableGateway->select(function(Select $select) 
    			{
    				$select->where(array('email' => $email));
    				$select->limit(1);
    			}
    	);
    	$row = (isset($rowset)) ? $rowset->current() : null;
     	return $row;
    }  
 }
