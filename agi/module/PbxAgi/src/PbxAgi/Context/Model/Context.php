<?php
namespace PbxAgi\Context\Model;

class Context
{
   public $id;
   public $custname;
   public $custdesc;
   public $contexttype;
   public $internalref;
   public $ivrref;  
   public $funcref; 
      
   public function exchangeArray($data)
   {
   		$this->id     = (isset($data['id'])) ? $data['id'] : null;
   		$this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
   		$this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;   	
   		$this->contexttype     = (isset($data['contexttype'])) ? $data['contexttype'] : null;
   		$this->internalref     = (isset($data['internalref'])) ? $data['internalref'] : null;
   		$this->ivrref     = (isset($data['ivrref'])) ? $data['ivrref'] : null;
   		$this->funcref     = (isset($data['funcref'])) ? $data['funcref'] : null;   		 
   }
    
   public function getArrayCopy()
   {
   	return get_object_vars($this);
   }      
}