<?php
namespace Vpbxui\Feature\Model;

interface FeatureTableInterface
{
	public function fetchAll($filter=null);	
	public function getFeature($id);	 
	public function saveFeature(Feature $context);	
	public function deleteFeature($id);
}
