<?php
namespace Vpbxui\Context\Model;

use Vpbxui\Context\Model\ContextTableInterface;
use Vpbxui\Context\Model\Context;
use Zend\Db\TableGateway\TableGateway;

class ContextTable implements ContextTableInterface
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
	
	public function getContext($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	 
	public function saveContext(Context $context)
	{
	
		$data = array(
				'custname' => $context->custname,
				'custdesc' => $context->custdesc,
				'contexttype' => $context->contexttype,
				'internalref' => $context->internalref,
				'ivrref' => $context->ivrref,
				'funcref' => $context->funcref
 		);
		
		$id = (int)$context->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
			$return = $this->tableGateway->getLastInsertValue();
		} else {
			if ($this->getContext($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
		return (isset($return))?$return:null;
	}
	
	public function deleteContext($id)
	{
		$this->tableGateway->delete(array('id' => $id));
	}
}