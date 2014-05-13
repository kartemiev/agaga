<?php
namespace PbxAgi\Trunk\Model;

class Trunk
{
	public $id;
	public $secret;
	public $custname;
	public $custdesc;
	public $name;
	public $defaultuser;
	public $callbackextension;
	public $callerid;
	
	public function exchangeArray($data)
	{
        $this->id     		= (isset($data['id'])) ? $data['id'] : null;
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->name     	= (isset($data['name'])) ? $data['name'] : null;        
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null; 
        $this->defaultuser     = (isset($data['defaultuser'])) ? $data['defaultuser'] : null;        
        $this->callbackextension     = (isset($data['callbackextension'])) ? $data['callbackextension'] : null;
        $this->callerid		   =     (isset($data['callerid'])) ? $data['callerid'] : null;
        $this->secret		   =     (isset($data['secret'])) ? $data['secret'] : null;
        
 	}
}