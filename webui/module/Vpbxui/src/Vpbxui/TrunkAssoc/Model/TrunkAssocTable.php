<?php
namespace Vpbxui\TrunkAssoc\Model;

use Vpbxui\TrunkAssoc\Model\TrunkAssocTableInterface;
use Vpbxui\TrunkAssoc\Model\TrunkAssoc;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
 
class TrunkAssocTable implements TrunkAssocTableInterface
{
    protected $tableGateway;
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
	public function deleteAllTrunkAssoc()
	{
	    $this->tableGateway->delete(array());
	}	
	public function getTrunkAssoc($id, $contextref)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id, 'contextref'=> $contextref));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	 
	public function saveTrunkAssoc(TrunkAssoc $trunkassoc)
	{
	
		$data = array(
				'trunkref' => $trunkassoc->trunkref,
				'contextref' => $trunkassoc->contextref
		);
		$id = (int)$trunkassoc->id;
		$this->tableGateway->insert($data);
		$return = $this->tableGateway->getLastInsertValue();
		return (isset($return))?$return:null;
	}
	
	public function deleteTrunkAssocByContext($contextref)
	{
		$this->tableGateway->delete(array('contextref' => $contextref));
	}
}