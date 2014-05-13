<?php
namespace Vpbxui\CdrMissedCallsCallCentre\Model;
class CdrMissedCallsCallCentre
{
    public $id;
    public $calldate;
    public $operatorcalledids;
    public $operatorcallednums;
    public $operatoravailany;
    public $operatoravail;
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->calldate     = (isset($data['calldate'])) ? $data['calldate'] : null;
        $this->operatorcalledids     = (isset($data['operatorcalledids'])) ? $data['operatorcalledids'] : null;
        $this->operatorcallednums     = (isset($data['operatorcallednums'])) ? $data['operatorcallednums'] : null;
        $this->operatoravailany     = (isset($data['operatoravailany'])) ? $data['operatoravailany'] : null;
        $this->operatoravail     = (isset($data['operatoravail'])) ? $data['operatoravail'] : null;        
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}