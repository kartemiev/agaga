<?php
namespace Vpbxui\Entity;

class User extends \ZfcUser\Entity\User
{
	protected $vpbxid;
	
	public function setVpbxid($vpbxid)
	{
		$this->vpbxid = $vpbxid;
		return $this;
	}
	
	public function getVpbxid()
	{
		return $this->vpbxid;
	}
}