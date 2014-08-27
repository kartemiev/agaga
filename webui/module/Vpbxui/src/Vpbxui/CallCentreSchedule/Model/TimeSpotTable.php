<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
use Vpbxui\Service\VpbxidProvider\VpbxidProviderInterface;
 
class TimeSpotTable implements TimeSpotTableInterface
{
    protected $tableGateway;
    protected $vpbxidProvider;
    public function __construct(TableGateway $tableGateway, VpbxidProviderInterface $vpbxidProvider)
    {
        $this->tableGateway = $tableGateway;
        $this->vpbxidProvider = $vpbxidProvider;
    }
    
    public function fetchaAll($filter = null, $limit = null, $offset = null)
    {
    	$vpbxid  = (int) $vpbxid;
    	$vpbxFilter = $this->vpbxidProvider->vpbxFilter;
    	$rowset = $this->tableGateway->select(function(Select $select) use ($filter,$limit, $offset, $vpbxFilter) 
    			{
    				$vpbxFilter($select);    				
    				$select->where($filter);
    				$select->limit($limit);
    				$select->offset($offset);
    			}
		);
    	 
    	return $rowset;
    }
    public function queryResultCount($filter = null)
    {
    	$vpbxid  = (int) $vpbxid;
    	$vpbxFilter = $this->vpbxidProvider->vpbxFilter;    	 
    	$rowset = $this->tableGateway->select(function(Select $select) use ($filter, $vpbxFilter) 
    			{
    				$select->where($filter);
    				$vpbxFilter($select);
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