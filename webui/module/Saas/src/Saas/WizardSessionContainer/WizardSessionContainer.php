<?php
namespace Saas\WizardSessionContainer;

use Zend\Session\Container as SessionContainer;
use Zend\Session\ManagerInterface;
use Saas\VpbxEnv\Model\VpbxEnv;
use Vpbxui\Extension\Model\Extension;
use Saas\FreeDid\Model\FreeDid;
use Saas\TempMedia\Model\TempMediaTableInterface;
use Saas\NumberAllowed\Model\NumberAllowed;

class WizardSessionContainer extends SessionContainer implements WizardSessionContainerInterface
{	
	protected  $did;
	protected  $internalnumbers;
	protected $tempMediaTable;
	public function __construct($name='Default',ManagerInterface $manager=null)
	{
		parent::__construct($name, $manager);
		$this->vpbxEnv = new VpbxEnv();
	    $this->wizardActionsCompletedList = array();	
	    if (!$this->numberAllowed)
	    {
	       $this->numberAllowed = new NumberAllowed();
	    }
 	}
	public function setDid(FreeDid $did)
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
	public function getNumbersAllowed()
	{
		
	}
	public function setTempMediaTable(TempMediaTableInterface $tempMediaTable)
	{
 	    $this->tempMediaTable = $tempMediaTable;
	}
}