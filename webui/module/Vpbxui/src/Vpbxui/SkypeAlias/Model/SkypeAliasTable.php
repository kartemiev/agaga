<?php
namespace Vpbxui\SkypeAlias\Model;

use Vpbxui\SkypeAlias\Model\SkypeAlias;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class SkypeAliasTable {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) {
     $select->order('number ASC');
    });
            $resultSet->buffer();

    	return $resultSet;
    }
    
    
    public function getSkypeAlias($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
           
    public function saveSkypeAlias(SkypeAlias $skypealias)
    {
        
    	$data = array(
    		'number' => $skypealias->number,
    		'skypeid' => $skypealias->skypeid,   
    		'custname' => $skypealias->custname,   
    		'custdesc' => $skypealias->custdesc,    			 
     	);
    	$id = (int)$skypealias->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getSkypeAlias($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
    public function deleteSkypeAlias($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
}
