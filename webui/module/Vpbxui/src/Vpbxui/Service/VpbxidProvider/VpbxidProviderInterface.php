<?php
namespace Vpbxui\Service\VpbxidProvider;

interface VpbxidProviderInterface
{
	function vpbxFilter($select);
 	function setVpbxId($vpbxid);
 	function getVpbxId();
 	function isSuperuser(); 	
 	function setSuperuser($state);
 }