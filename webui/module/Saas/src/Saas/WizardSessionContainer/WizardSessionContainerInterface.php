<?php
namespace Saas\WizardSessionContainer;

use Vpbxui\Extension\Model\Extension;
use Saas\VpbxEnv\Model\VpbxEnv;
use Saas\TempMedia\Model\TempMedia;
use Saas\FreeDid\Model\FreeDid;

interface WizardSessionContainerInterface
{
    function setDid(FreeDid $did);
	 
	function getDid();
	 
	function setVpbxEnv(VpbxEnv $vpbxEnv);
	 
	function getVpbxEnv();
	 
	function setMedia(TempMedia $media);
	 
	function getMedia();
	 
	function getInternalNumbers();
	 
	function addInternalNumber(Extension $extension);
	 
}