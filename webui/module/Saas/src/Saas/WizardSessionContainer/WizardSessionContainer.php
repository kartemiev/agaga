<?php
namespace Saas\WizardSessionContainer;

use Zend\Session\Container as SessionContainer;
use Agaga\Entity\Did;
use Zend\Session\ManagerInterface;
use Saas\VpbxEnv\Model\VpbxEnv;
use Saas\TempMedia\Model\TempMedia;
use Vpbxui\Extension\Model\Extension;

class WizardSessionContainer extends SessionContainer implements WizardSessionContainerInterface
{	
	protected $did;
	protected $vpbxEnv;	
	protected $media;
	protected $internalnumbers;
	public function setDid(Did $did)
	{
		$this->did = $did;
		return $this;
	}	
	public function getDid()
	{
		return $this->did;
	}
	public function setVpbxEnv(VpbxEnv $vpbxEnv)
	{
		$this->vpbxEnv = $vpbxEnv;
		return $this;
	}
	public function getVpbxEnv()
	{
		return $this->vpbxEnv;
	}
	public function setMedia(TempMedia $media)
	{
		$this->media = $media;
		return $this;
	}
	public function getMedia()
	{
		return $this->media;
	}
	public function getInternalNumbers()
	{
		if (!$this->internalnumbers)
		{
			$this->internalnumbers = new \ArrayObject();
		}
		return $this->internalnumbers;
	}
	public function addInternalNumber(Extension $extension)
	{
		$this->internalnumbers->append($extension);
		return $this;
	}
	
}