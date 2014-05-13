<?php
namespace PbxAgi\ExtensionDefaults\Model;


class ExtensionDefaults
{
    public $vpbxid;
    public $transfer;
    public $statuschange;
    public $incoming;
    public $hold;
    public $forwarding;
    public $number_status;
     
    public $diversion_unconditional_status;
    public $diversion_unconditional_number;
    public $diversion_unavail_status;
    public $diversion_unavail_number;
    public $diversion_busy_status;
    public $diversion_busy_number;
    public $diversion_noanswer_status;
    public $diversion_noanswer_number;
    
    public $diversion_unconditional_landingtype;
    public $diversion_unavail_landingtype;
    public $diversion_busy_landingtype;
    public $diversion_noanswer_landingtype;
    public $diversion_noanswer_duration;
    public $outgoingcallspermission;
    public $extensionrecord;
    
     public function exchangeArray($data)
    {
        $this->transfer     = (isset($data['transfer'])) ? $data['transfer'] : null;        
        $this->statuschange     = (isset($data['statuschange'])) ? $data['statuschange'] : null;
        $this->incoming     = (isset($data['incoming'])) ? $data['incoming'] : null;
        $this->hold     = (isset($data['hold'])) ? $data['hold'] : null;
        $this->forwarding     = (isset($data['forwarding'])) ? $data['forwarding'] : null; 
        $this->number_status     = (isset($data['number_status'])) ? $data['number_status'] : null;    
        
        $this->diversion_unconditional_status     = (isset($data['diversion_unconditional_status'])) ? $data['diversion_unconditional_status'] : null;
        $this->diversion_unconditional_number     = (isset($data['diversion_unconditional_number'])) ? $data['diversion_unconditional_number'] : null;
        $this->diversion_unavail_status     = (isset($data['diversion_unavail_status'])) ? $data['diversion_unavail_status'] : null;
        $this->diversion_unavail_number     = (isset($data['diversion_unavail_number'])) ? $data['diversion_unavail_number'] : null;
        $this->diversion_busy_status     = (isset($data['diversion_busy_status'])) ? $data['diversion_busy_status'] : null;
        $this->diversion_busy_number     = (isset($data['diversion_busy_number'])) ? $data['diversion_busy_number'] : null;
        
        $this->diversion_noanswer_status     = (isset($data['diversion_noanswer_status'])) ? $data['diversion_noanswer_status'] : null;
        $this->diversion_noanswer_number     = (isset($data['diversion_noanswer_number'])) ? $data['diversion_noanswer_number'] : null;
                
        $this->diversion_unconditional_landingtype     = (isset($data['diversion_unconditional_landingtype'])) ? $data['diversion_unconditional_landingtype'] : null;
        $this->diversion_unavail_landingtype     = (isset($data['diversion_unavail_landingtype'])) ? $data['diversion_unavail_landingtype'] : null;
        $this->diversion_busy_landingtype     = (isset($data['diversion_busy_landingtype'])) ? $data['diversion_busy_landingtype'] : null;
        $this->diversion_noanswer_landingtype     = (isset($data['diversion_noanswer_landingtype'])) ? $data['diversion_noanswer_landingtype'] : null;
        $this->diversion_noanswer_duration     = (isset($data['diversion_noanswer_duration'])) ? $data['diversion_noanswer_duration'] : null;
        $this->outgoingcallspermission     = (isset($data['outgoingcallspermission'])) ? $data['outgoingcallspermission'] : null;
        $this->extensionrecord     = (isset($data['extensionrecord'])) ? $data['extensionrecord'] : null;
        
      }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

 }
