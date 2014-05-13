<?php
namespace Vpbxui\Offday\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Vpbxui\Offday\Model\Offday;

class OffdayTable implements OffdayTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($select, $filter=null,$orderseq=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter,$orderseq){
        $select->order('rdate ASC');        
          $select->where($filter);
     });
            $resultSet->buffer();

    	return $resultSet;
    }
    
     public function getOffday($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
   
    public function getOffdayByDate($date)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('rdate' => $date));
        $row = $rowset->current();
        return $row;
    }
    
    
    public function saveOffday(Offday $offday)
    {
        
    	$data = array(
    		'rdate' => $offday->rdate,
    	    'isworking' => $offday->isworking,
    	    'cute' => $offday->cute,
    		'apply_specialtime' => $offday->apply_specialtime,
    		'start_time'=>$offday->start_time,
    		'end_time'=>$offday->end_time,
    	    'name' => $offday->name,
    	    'comment' => $offday->comment,    	 
    	);
    	$id = (int)$offday->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getOffday($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    }
    
    public function deleteOffday($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
}
