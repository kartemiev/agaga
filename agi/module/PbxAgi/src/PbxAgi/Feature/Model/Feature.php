<?php
namespace PbxAgi\Feature\Model;

class Feature
{
   public $id;
   public $custname;
   public $custdesc;
        
   public function exchangeArray($data)
   {
   		$this->id     = (isset($data['id'])) ? $data['id'] : null;
   		$this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
   		$this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;   	   
   }
    
   public function getArrayCopy()
   {
   	return get_object_vars($this);
   }      
}