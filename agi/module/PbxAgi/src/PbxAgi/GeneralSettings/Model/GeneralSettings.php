<?php
namespace PbxAgi\GeneralSettings\Model;

class GeneralSettings
{
    public $vpbxid;
    public $vmtimeout;
    public $greeting;
    public $mohtone;
    public $ringingtone;
    public $greetingofftime;
    public $mediarepospath;
    public $mohinternal;
    
     
    public function exchangeArray($data)
    {
        $this->vpbxid     = (isset($data['vpbxid'])) ? $data['vpbxid'] : null;        
        $this->vmtimeout     = (isset($data['vmtimeout'])) ? $data['vmtimeout'] : null;
        $this->greeting     = (isset($data['greeting'])) ? $data['greeting'] : null;
        $this->greetingofftime     = (isset($data['greetingofftime'])) ? $data['greetingofftime'] : null;
        $this->mohtone     = (isset($data['mohtone'])) ? $data['mohtone'] : null;
        $this->ringingtone     = (isset($data['ringingtone'])) ? $data['ringingtone'] : null;      
        $this->mediarepospath     = (isset($data['mediarepospath'])) ? $data['mediarepospath'] : null;        
        $this->mohinternal     = (isset($data['mohinternal'])) ? $data['mohinternal'] : null;
        
     }     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }      
}
