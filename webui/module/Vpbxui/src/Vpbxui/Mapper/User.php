<?php
namespace Vpbxui\Mapper;

use ZfcUser\Mapper\User as ZfcUser;
use Vpbxui\Service\VpbxidProvider\VpbxidProviderInterface;

class User extends ZfcUser
{
	protected $vpbxidProvider;
	public function __construct(VpbxidProviderInterface $vpbxidProvider)
	{
		$this->vpbxidProvider = $vpbxidProvider;
	}
 	public function findByEmail($email)
	{
		$select = $this->getSelect()
		->where(array('email' => $email));
		$this->addVpbxIdFilter($select);
		$entity = $this->select($select)->current();
		$this->getEventManager()->trigger('find', $this, array('entity' => $entity));
		return $entity;
	}
	
	public function findByUsername($username)
	{
		$select = $this->getSelect()
		->where(array('username' => $username));
		$this->addVpbxIdFilter($select);
		$entity = $this->select($select)->current();
		$this->getEventManager()->trigger('find', $this, array('entity' => $entity));
		return $entity;
	}
	
	public function findById($id)
	{
		$select = $this->getSelect()
		->where(array('user_id' => $id));	
		$this->addVpbxIdFilter($select);		
		$entity = $this->select($select)->current();
		$this->getEventManager()->trigger('find', $this, array('entity' => $entity));
		return $entity;
	}
	
	public function getTableName()
	{
		return $this->tableName;
	}
	
	public function setTableName($tableName)
	{
		$this->tableName=$tableName;
	}
	
	public function insert($entity, $tableName = null, Hydrator $hydrator = null)
	{
		
		$hydrator = $hydrator ?: $this->getHydrator();
		$result = parent::insert($entity, $tableName, $hydrator);
		$hydrator->hydrate(array('user_id' => $result->getGeneratedValue()), $entity);
		return $result;
	}
	
	public function update($entity, $where = null, $tableName = null, Hydrator $hydrator = null)
	{
		if (!$where) {
			$where = array('user_id' => $entity->getId());
		}
		if (!$entity->getVpbxid())
		{
			
		}		
		return parent::update($entity, $where, $tableName, $hydrator);
	}
	protected function addVpbxIdFilter($select)
	{
		$vpbxProvider = $this->vpbxidProvider;
		if (!$vpbxidProvider->isSuperuser())
		{
			$select->where->equalTo('vpbxid', $vpbxProvider->getVpbxId());
		}		
	}
}