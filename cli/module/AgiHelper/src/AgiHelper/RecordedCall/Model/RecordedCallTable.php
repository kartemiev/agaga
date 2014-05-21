<?php
namespace AgiHelper\RecordedCall\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;
use Zend\Console\Prompt\Select;
use AgiHelper\RecordedCall\Model\RecordedCall;

class RecordedCallTable implements RecordedCallTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null, $orderby = null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter, $orderby){
    		$select->order($orderby);
    		$select->where($filter);
    	});
    	$resultSet->buffer();
    
    	return $resultSet;
    }
    
    public function getRecordedCall($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
    	return $row;
    }
    
    public function saveRecordedCall(RecordedCall $recordedcall)
    {
    
    	$data = array(
    			'cdrref' => $recordedcall->cdrref,
    			'filesize' => $recordedcall->filesize,
    			'status' => $recordedcall->status    			    
    	);
    	 
    	$id = (int)$recordedcall->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getRecordedCall($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }   
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}
