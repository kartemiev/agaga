<?php
namespace PbxAgi\ExtensionGroup\Model;

class ExtensionGroup
{
    public $id;
    public $name;
    public $transfer;
    public $statuschange;
    public $incoming;
    public $memberofcallcentreque;
    public $hold;
    public $forwarding;
    public $custdesc;
    public $number_status;
    public $group_members_status;
    public $vpbxid;
    public $outgoingcallspermission;
    public $extensionrecord;
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->name     = (isset($data['name'])) ? $data['name'] : null;        
        $this->transfer     = (isset($data['transfer'])) ? $data['transfer'] : null;        
        $this->statuschange     = (isset($data['statuschange'])) ? $data['statuschange'] : null;
        $this->incoming     = (isset($data['incoming'])) ? $data['incoming'] : null;
        $this->memberofcallcentreque     = (isset($data['memberofcallcentreque'])) ? $data['memberofcallcentreque'] : null;
        $this->hold     = (isset($data['hold'])) ? $data['hold'] : null;
        $this->forwarding     = (isset($data['forwarding'])) ? $data['forwarding'] : null; 
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null; 
        $this->number_status     = (isset($data['number_status'])) ? $data['number_status'] : null;
        $this->group_members_status     = (isset($data['group_members_status'])) ? $data['group_members_status'] : null;
        $this->vpbxid     = (isset($data['vpbxid'])) ? $data['vpbxid'] : null;        
        $this->outgoingcallspermission     = (isset($data['outgoingcallspermission'])) ? $data['outgoingcallspermission'] : null;
        $this->extensionrecord     = (isset($data['extensionrecord'])) ? $data['extensionrecord'] : null;
        
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }   
}
