<?php
namespace Vpbxui\DefaultDenyPermit\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
 
class DefaultDenyPermitTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
     }
    public function getDefaultDenyPermit()
    {
    	$resultSet = $this->tableGateway->select();
        $resultSet->buffer();
        $result = $resultSet->current();
    	return $result;
    }
    public function saveDefautDenyPermit(DefaultDenyPermit $defaultDenyPermit)
    {        
    	$data = array(
    	    'deny' => $defaultDenyPermit->deny,  
    	    'permit' => $defaultDenyPermit->permit    	    	
    	);
        $this->tableGateway->update($data);   
    }    
}
