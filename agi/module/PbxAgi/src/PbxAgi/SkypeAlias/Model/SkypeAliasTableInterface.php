<?php
namespace PbxAgi\SkypeAlias\Model;

interface SkypeAliasTableInterface  
{
	function fetchAll($filter=null);
	function getSkypeAlias($id); 	
	function getSkypeAliasByExten($exten);
	
}
