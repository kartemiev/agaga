<?php
namespace Vpbxui\Trunk\Model;

interface TrunkTableInterface
{
	function fetchAll($filter=null);
	function getTrunk($id);
	function saveTrunk(Trunk $trunk);
	function deleteTrunk($id);
	function deleteAllTrunks();		
}