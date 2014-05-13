<?php
namespace PbxAgi\FaxUser\Model;

class FaxUser
{
    public $id;
    public $custname;
    public $email;
    public function exchangeArray($data)
    {
    	$this->id = (isset($data['id']))? $data['id']:null;    	 
        $this->custname = (isset($data['custname']))? $data['custname']:null;
        $this->email = (isset($data['email']))? $data['email']:null;        
    }
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }           
}