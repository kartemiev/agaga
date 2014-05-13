<?php
namespace Vpbxui\RegEntry\Model;

interface RegEntryTableInterface
{
	function fetchAll($filter=null);
			 
	function saveRegEntry(RegEntry $regentry);
	
	function deleteRegEntryByNumberMatch($numbermatchref);
	
}