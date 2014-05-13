<?php
namespace PbxAgi\TrunkDestination\Model;

class TrunkDestination
{
 	public $routeref;
	public $trunkref; 
 	public $numbermatchref;	
 		
	public function exchangeArray($data)
	{
        $this->routeref     		= (isset($data['routeref'])) ? $data['routeref'] : null;
        $this->trunkref     		= (isset($data['trunkref'])) ? $data['trunkref'] : null;
        $this->numbermatchref       = (isset($data['numbermatchref'])) ? $data['numbermatchref'] : null;        
 	}
	public function getArrayCopy()
	{
		return get_object_vars($this); 
	}	
	 
}