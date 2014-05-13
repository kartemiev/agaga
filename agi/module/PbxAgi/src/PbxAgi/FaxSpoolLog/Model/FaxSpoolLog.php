<?php
namespace PbxAgi\FaxSpoolLog\Model;

class FaxSpoolLog  
{ 
	public $id;
	public $spoolref;
    public $action;
    public $result;    
    public $reason;
    public function exchangeArray($data)
    {    	
        $this->spoolref = (isset($data['spoolref']))?$data['spoolref']:null;        
        $this->action = (isset($data['action']))?$data['action']:null;
        $this->result = (isset($data['result']))?$data['result']:null;  
        $this->reason = (isset($data['reason']))?$data['reason']:null;        
    }	 
}
