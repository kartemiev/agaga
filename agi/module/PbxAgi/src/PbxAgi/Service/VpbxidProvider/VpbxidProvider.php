<?php
namespace PbxAgi\Service\VpbxidProvider;

use PbxAgi\Service\VpbxidProvider\VpbxidProviderInterface;
use PbxAgi\Entity\CallEntityInterface;

class VpbxidProvider implements VpbxidProviderInterface
{
	protected $vpbxid;
	protected $call;
	protected $isSuperuser;
	public function __construct(CallEntityInterface $call)
	{
		$this->call = $call;
	}
	public function vpbxFilter($select)
	{
		$vpbxid = $this->getVpbxId();
		if (NULL!==$vpbxid)
		{
			$select->where->equalTo('vpbxid',$vpbxid);
		}
	}
	public function setVpbxId($vpbxid)
	{
		$this->vpbxid = $vpbxid;
		return $this;
	}
	public function getVpbxId()
	{
		if (!$this->vpbxid)
		{
			$this->vpbxid = ($this->call->getCallOriginator())?$this->call->getCallOriginator()->getVpbxid():null;
		}
		return $this->vpbxid;
	}	
	public function isSuperuser()
	{
		if (!isset($this->isSuperuser))
		{
			$this->isSuperuser = (-1==$this->getVpbxId());
		}
		return $this->isSuperuser;
	}
	public function setSuperuser($state)
	{
		$this->isSuperuser = $state;
		return $this;
	}
}
