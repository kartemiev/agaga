<?php
namespace PbxAgi\OperatorStatusLog\Model;

use PbxAgi\OperatorStatusLog\Model\OperatorStatusLogInterface;

class OperatorStatusLog extends \ArrayObject implements OperatorStatusLogInterface
{
    public $extension;
    public $operatorstatus;
    public function getExtension() {
        return $this->extension;
    }

    public function setExtension($extension) {
        $this->extension = $extension;
    }
    public function getOperatorstatus() {
        return $this->operatorstatus;
    }

    public function setOperatorstatus($operatorstatus) {
        $this->operatorstatus = $operatorstatus;
    }
    public function exchangeArray($data)
    {
    	$this->extension = (isset($data['extension']))?$data['extension']:null;
    	$this->operatorstatus = (isset($data['operatorstatus']))?$data['operatorstatus']:null;
    	 
    }

}

