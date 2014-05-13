<?php
namespace PbxAgi\Trunk\Model;

interface TrunkTableInterface
{
	public function fetchAll($filter=null);
	public function getTrunk($id);
	public function getTrunkByCallbackExten($callbackextension);
}