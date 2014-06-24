<?php
namespace Vpbxui\Service\VpbxidProvider;

use Vpbxui\Service\VpbxidProvider\VpbxidProviderInterface;

class VpbxidProvider implements VpbxidProviderInterface
{
	protected $vpbxid;
	protected $authService;
	protected $isSuperuser;
	public function __construct($authService)
	{
		$this->authService = $authService;
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
			$vpbxid = ($this->authService->hasIdentity())?$this->authService->getIdentity()->getVpbxid():null;
		}
		return $vpbxid;
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
