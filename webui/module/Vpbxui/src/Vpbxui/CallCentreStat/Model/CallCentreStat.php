<?php
namespace Vpbxui\CallCentreStat\Model;


class CallCentreStat
{
    public $totaltoday;
    public $missedtoday;    
    public $total24hrs;
    public $missed24hrs;     
    public $totalthismonth;
    public $missedthismonth;
    public $totalintegral;
    public $missedintegral;
    public $total30days;
    public $missed30days;
    
    
    public function exchangeArray($data)
    {
        $this->totaltoday     = (isset($data['totaltoday'])) ? $data['totaltoday'] : null;
        $this->missedtoday     = (isset($data['missedtoday'])) ? $data['missedtoday'] : null;        
        $this->total24hrs     = (isset($data['total24hrs'])) ? $data['total24hrs'] : null;
        $this->missed24hrs     = (isset($data['missed24hrs'])) ? $data['missed24hrs'] : null;        
        $this->totalthismonth     = (isset($data['totalthismonth'])) ? $data['totalthismonth'] : null;
        $this->missedthismonth     = (isset($data['missedthismonth'])) ? $data['missedthismonth'] : null;  
        $this->total30days     = (isset($data['total30days'])) ? $data['total30days'] : null;
        $this->missed30days     = (isset($data['missed30days'])) ? $data['missed30days'] : null;
        $this->totaltoday     = (isset($data['totaltoday'])) ? $data['totaltoday'] : null;
        $this->missedtoday     = (isset($data['missedtoday'])) ? $data['missedtoday'] : null;        
        $this->totalintegral     = (isset($data['totalintegral'])) ? $data['totalintegral'] : null;
        $this->missedintegral     = (isset($data['missedintegral'])) ? $data['missedintegral'] : null;                
        
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}