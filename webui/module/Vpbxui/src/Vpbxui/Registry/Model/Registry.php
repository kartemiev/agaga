<?php
namespace Vpbxui\Registry\Model;

class Registry
{
	 public $event;
     public $actionid;     
	 public $host;
	 public $port;
	 public $username;
	 public $domain;
	 public $domainport;
	 public $refresh;
	 public $state;
	 public $registrationtime;
	 public function exchangeArray($data)
	 {
	 	$this->event     = (isset($data['event'])) ? $data['event'] : null;
	 	$this->actionid     = (isset($data['actionid'])) ? $data['actionid'] : null;
	 	$this->host     = (isset($data['host'])) ? $data['host'] : null;
	 	$this->username     = (isset($data['username'])) ? $data['username'] : null;
	 	$this->domain     = (isset($data['domain'])) ? $data['domain'] : null;
	 	$this->domainport     = (isset($data['domainport'])) ? $data['domainport'] : null;
	 	$this->refresh     = (isset($data['refresh'])) ? $data['refresh'] : null;
	 	$this->state     = (isset($data['state'])) ? $data['state'] : null;
	 	$this->registrationtime     = (isset($data['registrationtime'])) ? $data['registrationtime'] : null;	 	 	 	 
	 }	  
	 public function getArrayCopy()
	 {
	 	return get_object_vars($this);
	 }	 
}