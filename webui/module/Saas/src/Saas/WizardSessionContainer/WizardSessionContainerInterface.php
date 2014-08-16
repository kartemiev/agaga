<?php
namespace Saas\WizardSessionContainer;

use Vpbxui\Extension\Model\Extension;
use Agaga\Entity\Did;
use Saas\VpbxEnv\Model\VpbxEnv;
use Saas\TempMedia\Model\TempMedia;

interface WizardSessionContainerInterface
{
	function setDid(Did $did);
 
	function getDid();
	 
	function setVpbxEnv(VpbxEnv $vpbxEnv);
	 
	function getVpbxEnv();
	 
	function setMedia(TempMedia $media);
	 
	function getMedia();
	 
	function getInternalNumbers();
	 
	function addInternalNumber(Extension $extension);
	 
}