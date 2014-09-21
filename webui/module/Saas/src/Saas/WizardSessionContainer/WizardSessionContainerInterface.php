<?php
namespace Saas\WizardSessionContainer;

use Vpbxui\Extension\Model\Extension;
use Saas\VpbxEnv\Model\VpbxEnv;
use Saas\FreeDid\Model\FreeDid;
use Saas\TempMedia\Model\TempMediaTableInterface;

interface WizardSessionContainerInterface
{
    function setDid(FreeDid $did);
	 
	function getDid();
	 
	function setVpbxEnv(VpbxEnv $vpbxEnv);
	 
	function getVpbxEnv();
	 
	function getInternalNumbers();
	 
	function addInternalNumber(Extension $extension);
    
	function setTempMediaTable(TempMediaTableInterface $tempMediaTable);
	
	 
}