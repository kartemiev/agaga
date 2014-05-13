<?php
namespace PbxAgi\TrunkAssoc\Model;

interface TrunkAssocTableInterface
{
	function fetchAll($filter = null, $limit = null);	
	function getTrunkAssocByTrunkId($trunkid);
}