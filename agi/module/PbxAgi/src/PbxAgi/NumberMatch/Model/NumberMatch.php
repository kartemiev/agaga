<?php
namespace PbxAgi\NumberMatch\Model;

class NumberMatch
{
    public $id;
    public $custname;
    public $regentries;
    public $custdesc;
       
     protected $inputFilter;                      
        
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->regentries     = (isset($data['regentries'])) ? $data['regentries'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;        
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }
 }
