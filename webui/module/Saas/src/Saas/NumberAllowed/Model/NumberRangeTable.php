<?php
namespace Saas\NumberAllowed\Model;

use Zend\Db\TableGateway\TableGateway;
use Saas\NumberAllowed\Model\NumberRange;

class NumberRangeTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
    	$resultSet = $this->tableGateway->select();
        $resultSet->buffer();
    	return $resultSet;
    }
    public function getNumberRange($id)
    {
        $resultSet = $this->tableGateway->select(array('id'=>$id));
        if (count($resultSet)>0)
        {
            $numberrange = $resultSet->current();
        }
        else 
        {
            $numberrange = null;
        }
        
        return $numberrange;
    }
    public function saveNumberRange(NumberRange $numberrange)
    {   
     
    	$data = array(
    			'value' => $numberrange->value,
    		);
    	$id = (int)$numberrange->id;
    	 
    	if ($id == 0) {
    		$lastid = $this->tableGateway->insert($data);     
     	} else {
    		if ($this->getNumberRange($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	$lastId = (isset($lastid))?$lastid:null;
    	return $lastId;
    }
    public function deleteAll()
    {
        $this->tableGateway->delete();
    }      
}
