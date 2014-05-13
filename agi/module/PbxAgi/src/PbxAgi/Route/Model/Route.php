<?php
namespace PbxAgi\Route\Model;

class Route
{
    public $id;
    public $custname;
    public $custdesc;
    public $destinations;
    public $isdefault;
    
     
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;
        $this->destinations     = (isset($data['destinations'])) ? $data['destinations'] : null;
        $this->isdefault     = (isset($data['isdefault'])) ? $data['isdefault'] : null;
        
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }     
 }
