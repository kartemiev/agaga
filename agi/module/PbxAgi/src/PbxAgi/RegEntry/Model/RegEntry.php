<?php
namespace PbxAgi\RegEntry\Model;
 
class RegEntry
{ 
    public $numbermatchref;
    public $regexpression;
 
    public function exchangeArray($data)
    {
     	$this->numbermatchref     = (isset($data['numbermatchref'])) ? $data['numbermatchref'] : null;
    	$this->regexpression     = (isset($data['regexpression'])) ? $data['regexpression'] : null;    
    }
     
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }     
}