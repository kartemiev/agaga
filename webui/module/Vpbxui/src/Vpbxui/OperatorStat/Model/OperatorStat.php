<?php
namespace Vpbxui\OperatorStat\Model;


class OperatorStat
{
    public $extension;
    
    public $average_integral;    
    public $average_today;
    public $average_thismonth;
    
    public $accepted_integral;
    public $accepted_today;
    public $accepted_thismonth;
    
    public $missed_integral;
    public $missed_today;
    public $missed_thismonth;
        
    public $activity_integral;
    public $activity_today;
    public $activity_thismonth;
    
    
    public function exchangeArray($data)
    {
        $this->extension     = (isset($data['extension'])) ? $data['extension'] : null;

        $this->average_integral     = (isset($data['average_integral'])) ? $data['average_integral'] : null;
        $this->average_today     = (isset($data['average_today'])) ? $data['average_today'] : null;
        $this->average_thismonth     = (isset($data['average_thismonth'])) ? $data['average_thismonth'] : null;
                        
        $this->accepted_integral     = (isset($data['accepted_integral'])) ? $data['accepted_integral'] : null;
        $this->accepted_today     = (isset($data['accepted_today'])) ? $data['accepted_today'] : null;
        $this->accepted_thismonth     = (isset($data['accepted_thismonth'])) ? $data['accepted_thismonth'] : null;
        
        $this->missed_integral     = (isset($data['missed_integral'])) ? $data['missed_integral'] : null;
        $this->missed_today     = (isset($data['missed_today'])) ? $data['missed_today'] : null;
        $this->missed_thismonth     = (isset($data['missed_thismonth'])) ? $data['missed_thismonth'] : null;
        
        $this->activity_integral     = (isset($data['activity_integral'])) ? $data['activity_integral'] : null;
        $this->activity_today     = (isset($data['activity_today'])) ? $data['activity_today'] : null;
        $this->activity_thismonth     = (isset($data['activity_thismonth'])) ? $data['activity_thismonth'] : null;
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}