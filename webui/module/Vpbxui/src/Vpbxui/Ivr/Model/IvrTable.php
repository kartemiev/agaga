<?php
namespace Vpbxui\Ivr\Model;

use Vpbxui\Ivr\Model\IvrTableInterface;
use Zend\Db\TableGateway\TableGateway;

class IvrTable implements IvrTableInterface
{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAll($filter=null)
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	public function deleteAllIvrs()
	{
	    $this->tableGateway->delete(array());
	}
	public function getIvr($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function saveIvr(Ivr $ivr)
	{
	
		$data = array(
				'custname' => $ivr->custname,
				'custdesc' => $ivr->custdesc,
		);
	
		$id = (int)$ivr->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
			$return = $this->tableGateway->getLastInsertValue();
		} else {
			if ($this->getIvr($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
		return (isset($return))?$return:null;
	}
	
	public function deleteIvr($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
}