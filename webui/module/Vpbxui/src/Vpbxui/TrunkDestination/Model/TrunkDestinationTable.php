<?php
namespace Vpbxui\TrunkDestination\Model;

use Vpbxui\TrunkDestination\Model\TrunkDestination;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Vpbxui\TrunkDestination\Model\TrunkDestinationTableInterface;

class TrunkDestinationTable implements TrunkDestinationTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter) {
     		$select->order('id ASC');
     		$select->where($filter);     		 
    	});
    	return $resultSet;
    }      
        
    public function saveTrunkDestination(TrunkDestination $trunkdestination)
    {    	
    	$data = array(
    		'routeref' => $trunkdestination->routeref,    			 
    		'trunkref' => $trunkdestination->trunkref,
    		'numbermatchref' => $trunkdestination->numbermatchref    			 
     	);
    
    	$result = $this->tableGateway->insert($data);
    	return $result;
    }
    
    public function deleteTrunkDestinationAll($route)
    {
    	$this->tableGateway->delete(array('routeref' => $route));
    }
    public function deleteAllTrunkDestinations()
    {
        $this->tableGateway->delete(array());
    }
}
