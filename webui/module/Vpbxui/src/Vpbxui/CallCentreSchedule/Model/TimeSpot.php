<?php
namespace Vpbxui\CallCentreSchedule\Model;

class TimeSpot
{
    public $spot; 
 	public $num;
    
    public function exchangeArray($data)
    {
        $this->spot     = (isset($data['spot'])) ? $data['spot'] : null;
        $this->num     = (isset($data['num'])) ? $data['num'] : null;       
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}