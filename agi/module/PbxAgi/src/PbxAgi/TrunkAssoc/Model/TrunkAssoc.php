<?php
namespace PbxAgi\TrunkAssoc\Model;
 
class TrunkAssoc  
{ 
    public $id;
    public $trunkref;
    public $contextref;
    
     
    public function exchangeArray($data)
    {
    	$this->id     = (isset($data['id'])) ? $data['id'] : null;
    	$this->trunkref     = (isset($data['trunkref'])) ? $data['trunkref'] : null;
    	$this->contextref     = (isset($data['contextref'])) ? $data['contextref'] : null;    
    }
     public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
 
}