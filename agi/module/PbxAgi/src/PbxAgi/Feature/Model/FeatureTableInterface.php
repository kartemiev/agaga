<?php
namespace PbxAgi\Feature\Model;

interface FeatureTableInterface
{
	public function fetchAll($filter=null);	
	public function getFeature($id);	 
}
