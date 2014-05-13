<?php
namespace Vpbxui\OperatorStatusLog\Model;

class OperatorStatusLog
{
    public $extension;
    public $operatorstatus;
        
    
    public function exchangeArray($data)
    {
        $this->extension     = (isset($data['extension'])) ? $data['extension'] : null;
        $this->operatorstatus = (isset($data['operatorstatus'])) ? $data['operatorstatus'] : null;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}