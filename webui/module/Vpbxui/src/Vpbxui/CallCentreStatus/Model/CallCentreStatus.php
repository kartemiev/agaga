<?php
namespace Vpbxui\CallCentreStatus\Model;

class CallCentreStatus
{
    public $statutory;
    public $overridestatus;    
    public $status;
  
    public function exchangeArray($data)
    {
        $this->statutory     = (isset($data['statutory'])) ? $data['statutory'] : null;
        $this->overridestatus     = (isset($data['overridestatus'])) ? $data['overridestatus'] : null;
        $this->status     = (isset($data['status'])) ? $data['status'] : null;
        
    
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}