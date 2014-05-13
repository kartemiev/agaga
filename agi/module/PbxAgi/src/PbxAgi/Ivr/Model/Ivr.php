<?php
namespace PbxAgi\Ivr\Model;

class Ivr
{
    public $id;
    public $custname;
    public $custdesc;    
   
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    public function exchangeArray($data)
    {
    	$this->id     = (isset($data['id'])) ? $data['id'] : null;
    	$this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
    	$this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;     
    } 
 }