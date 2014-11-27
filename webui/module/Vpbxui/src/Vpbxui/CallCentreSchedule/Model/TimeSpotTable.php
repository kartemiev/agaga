<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class TimeSpotTable implements TimeSpotTableInterface
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
     }
    
    public function fetchaAll($filter = null, $limit = null, $offset = null)
    {
    	$rowset = $this->tableGateway->select(function(Select $select) use ($filter,$limit, $offset) 
    			{
    				$select->where($filter);
    				$select->limit($limit);
    				$select->offset($offset);
    			}
		);
    	 
    	return $rowset;
    }
    public function queryResultCount($filter = null)
    {
    	$rowset = $this->tableGateway->select(function(Select $select) use ($filter) 
    			{
    				$select->where($filter);
    				$select->columns(array('num' => new \Zend\Db\Sql\Expression('COUNT(*)')));    				
     			}
		);
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not fetch - the table is empty");
    	}
     	return $row;
    }
        
   
}