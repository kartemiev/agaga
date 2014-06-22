<?php
namespace Vpbxui\Service\VpbxContainer;

class VpbxContainer implements VpbxContainerInterface
{
	protected $vpbxid;
	public function getVpbxid()
	{
		return $this->vpbxid;
	}
	public function setVpbxid($vpbxid)
	{
		$this->vpbxid;
	}
}