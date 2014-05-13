<?php
namespace PbxAgi\RegEntry\Model;

use PbxAgi\RegEntry\Model\RegEntryTableInterface;
use PbxAgi\RegEntry\Model\RegEntry;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class RegEntryTable implements RegEntryTableInterface
{
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
		$resultSet->buffer();
	
		return $resultSet;
	}
			
}