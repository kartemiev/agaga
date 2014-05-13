<?php
namespace Vpbxui\Trunk\Model;

interface TrunkTableInterface
{
	public function fetchAll($filter=null);
	public function getTrunk($id);
	public function saveTrunk(Trunk $trunk);
	public function deleteTrunk($id);
	
}