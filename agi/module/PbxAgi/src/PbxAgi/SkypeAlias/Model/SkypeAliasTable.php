<?php
namespace PbxAgi\SkypeAlias\Model;

use PbxAgi\SkypeAlias\Model\SkypeAlias;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use PbxAgi\SkypeAlias\Model\SkypeAliasTableInterface;

class SkypeAliasTable implements SkypeAliasTableInterface {

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
    public function getSkypeAliasByExten($exten)
    {
    	$rowset = $this->tableGateway->select(
    			array('number' => $exten)
    	);
    	if($rowset)
    	{
    		$row = $rowset->current();
    	}
    	return $row;
    }       
 
}
