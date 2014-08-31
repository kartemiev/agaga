<?php
namespace PbxAgi\Service\VpbxidProvider;

interface VpbxidProviderInterface
{
	public function vpbxFilter($select);
 	public function setVpbxId($vpbxid);
 	public function getVpbxId();
 	public function isSuperuser(); 	
 	public function setSuperuser($state);
}