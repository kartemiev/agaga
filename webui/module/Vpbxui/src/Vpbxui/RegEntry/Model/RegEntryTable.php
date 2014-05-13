<?php
namespace Vpbxui\RegEntry\Model;

use Vpbxui\RegEntry\Model\RegEntryTableInterface;
use Vpbxui\RegEntry\Model\RegEntry;
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
			 
	public function saveRegEntry(RegEntry $regentry)
	{
		$data = array(
				'numbermatchref' => $regentry->numbermatchref,
				'regexpression' => $regentry->regexpression
		);
		$result = $this->tableGateway->insert($data);
		return $result;
	}
	
	public function deleteRegEntryByNumberMatch($numbermatchref)
	{
		$this->tableGateway->delete(array('numbermatchref' => $numbermatchref));
	}
}