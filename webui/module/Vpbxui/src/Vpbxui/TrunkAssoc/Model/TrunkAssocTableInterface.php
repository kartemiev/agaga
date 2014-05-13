<?php
namespace Vpbxui\TrunkAssoc\Model;

interface TrunkAssocTableInterface
{
	function fetchAll($filter=null);
	function getTrunkAssoc($id, $contextref);	
	function saveTrunkAssoc(TrunkAssoc $trunkassoc);	
	function deleteTrunkAssocByContext($contextref);
}