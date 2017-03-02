<?php
namespace Vpbxui\NumberMatch\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Vpbxui\NumberMatch\Model\NumberMatch;

class NumberMatchTable implements NumberMatchTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null,$orderseq=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter,$orderseq){
    		if (null!=$filter)
    		{
            	$select->where($filter);
    		}
     });
            $resultSet->buffer();

    	return $resultSet;
    }
    public function deleteAllNumberMatches()
    {
        $this->tableGateway->delete(array());
    }
     public function getNumberMatch($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
       
    public function saveNumberMatch(NumberMatch $numbermatch)
    {   
     
    	$data = array(
    			'custname' => $numbermatch->custname,
    	    	'custdesc' => $numbermatch->custdesc
    		);
    	$id = (int)$numbermatch->id;
    	 
    	if ($id == 0) {
    		$lastid = $this->tableGateway->insert($data);     
     	} else {
    		if ($this->getNumberMatch($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	$lastId = (isset($lastid))?$lastid:null;
    	return $lastId;
    }    
    public function deleteNumberMatch($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
}
