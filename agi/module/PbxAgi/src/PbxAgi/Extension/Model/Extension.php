<?php
namespace PbxAgi\Extension\Model;

use PbxAgi\Extension\Model\ExtensionInterface;

class Extension implements ExtensionInterface 
{  
    public $id;
    public $extension;
    public $extensiongroup;    
    public $extensiontype;
    public $name;    
    public $outgoingcallspermission;    
    public $transfer;    
    public $statuschange;    
    public $incoming;    
    public $hold;    
    public $forwarding;    
    public $memberofcallcentreque;
    public $mailbox;    
    public $callsequence;
    public $number_status;
    public $extensionrecord;    
    public $peertype;
    public $diversion_unconditional_status;
    public $diversion_unconditional_number;
    public $diversion_unavail_status;
    public $diversion_unavail_number;
    public $diversion_busy_status;
    public $diversion_busy_number;
    public $diversion_noanswer_status;
    public $diversion_noanswer_number;    
    public $diversion_unconditional_landingtype;    
    public $diversion_busy_landingtype;
    public $diversion_noanswer_landingtype;
    public $diversion_unavail_landingtype;
    public $diversion_noanswer_duration;
    public $vpbxid;
    public function exchangeArray($data)
    {
    	$this->id = (isset($data['id'])) ? $data['id'] : null;
    	$this->extension = (isset($data['extension'])) ? $data['extension'] : null;
    	$this->extensiongroup = (isset($data['extensiongroup'])) ? $data['extensiongroup'] : null;
     	$this->extensiontype = (isset($data['extensiontype'])) ? $data['extensiontype'] : null;
     	$this->name = (isset($data['name'])) ? $data['name'] : null;
     	$this->outgoingcallspermission = (isset($data['outgoingcallspermission'])) ? $data['outgoingcallspermission'] : null;
     	$this->transfer = (isset($data['transfer'])) ? $data['transfer'] : null;
     	$this->statuschange = (isset($data['statuschange'])) ? $data['statuschange'] : null;
     	$this->incoming = (isset($data['incoming'])) ? $data['incoming'] : null;
     	$this->hold = (isset($data['hold'])) ? $data['hold'] : null;
     	$this->forwarding = (isset($data['forwarding'])) ? $data['forwarding'] : null;
     	$this->memberofcallcentreque = (isset($data['memberofcallcentreque'])) ? $data['memberofcallcentreque'] : null;
     	$this->mailbox = (isset($data['mailbox'])) ? $data['mailbox'] : null;
     	$this->callsequence = (isset($data['callsequence'])) ? $data['callsequence'] : null;
     	$this->number_status = (isset($data['number_status'])) ? $data['number_status'] : null;
     	$this->peertype = (isset($data['peertype'])) ? $data['peertype'] : null;
     	$this->extensionrecord = (isset($data['extensionrecord'])) ? $data['extensionrecord'] : null;;     	
     	$this->diversion_unconditional_status = (isset($data['diversion_unconditional_status'])) ? $data['diversion_unconditional_status'] : null;
     	$this->diversion_unconditional_number = (isset($data['diversion_unconditional_number'])) ? $data['diversion_unconditional_number'] : null;
     	$this->diversion_unavail_status = (isset($data['diversion_unavail_status'])) ? $data['diversion_unavail_status'] : null;
     	$this->diversion_unavail_number = (isset($data['diversion_unavail_number'])) ? $data['diversion_unavail_number'] : null;
     	$this->diversion_busy_status = (isset($data['diversion_busy_status'])) ? $data['diversion_busy_status'] : null;
     	$this->diversion_busy_number = (isset($data['diversion_busy_number'])) ? $data['diversion_busy_number'] : null;
     	$this->diversion_noanswer_status = (isset($data['diversion_noanswer_status'])) ? $data['diversion_noanswer_status'] : null;
     	$this->diversion_noanswer_number = (isset($data['diversion_noanswer_number'])) ? $data['diversion_noanswer_number'] : null;
      	$this->diversion_unconditional_landingtype = (isset($data['diversion_unconditional_landingtype'])) ? $data['diversion_unconditional_landingtype'] : null;
     	$this->diversion_busy_landingtype = (isset($data['diversion_busy_landingtype'])) ? $data['diversion_busy_landingtype'] : null;
     	$this->diversion_noanswer_landingtype = (isset($data['diversion_noanswer_landingtype'])) ? $data['diversion_noanswer_landingtype'] : null;
     	$this->diversion_unavail_landingtype = (isset($data['diversion_unavail_landingtype'])) ? $data['diversion_unavail_landingtype'] : null;
     	$this->diversion_noanswer_duration =  (isset($data['diversion_noanswer_duration'])) ? $data['diversion_noanswer_duration'] : null;
     	$this->vpbxid =  (isset($data['vpbxid'])) ? $data['vpbxid'] : null;
     	
     }
    
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

 public function getId() {
  return $this->id;
 }
 
 public function setId($id) {
  $this->id = $id;
  return $this;
 }
 
 public function getExtension() {
  return $this->extension;
 }
 
 public function setExtension($extension) {
  $this->extension = $extension;
  return $this;
 }
 
 public function getExtensiongroup() {
  return $this->extensiongroup;
 }
 
 public function setExtensiongroup($extensiongroup) {
  $this->extensiongroup = $extensiongroup;
  return $this;
 }
 
 public function getExtensiontype() {
  return $this->extensiontype;
 }
 
 public function setExtensiontype($extensiontype) {
  $this->extensiontype = $extensiontype;
  return $this;
 }
 
 public function getName() {
  return $this->name;
 }
 
 public function setName($name) {
  $this->name = $name;
  return $this;
 }
 
 public function getOutgoingcallspermission() {
  return $this->outgoingcallspermission;
 }
 
 public function setOutgoingcallspermission($outgoingcallspermission) {
  $this->outgoingcallspermission = $outgoingcallspermission;
  return $this;
 }
 
 public function getTransfer() {
  return $this->transfer;
 }
 
 public function setTransfer($transfer) {
  $this->transfer = $transfer;
  return $this;
 }
 
 public function getStatuschange() {
  return $this->statuschange;
 }
 
 public function setStatuschange($statuschange) {
  $this->statuschange = $statuschange;
  return $this;
 }
 
 public function getIncoming() {
  return $this->incoming;
 }
 
 public function setIncoming($incoming) {
  $this->incoming = $incoming;
  return $this;
 }
 
 public function getHold() {
  return $this->hold;
 }
 
 public function setHold($hold) {
  $this->hold = $hold;
  return $this;
 }
 
 public function getForwarding() {
  return $this->forwarding;
 }
 
 public function setForwarding($forwarding) {
  $this->forwarding = $forwarding;
  return $this;
 }
 
 public function getMemberofcallcentreque() {
  return $this->memberofcallcentreque;
 }
 
 public function setMemberofcallcentreque($memberofcallcentreque) {
  $this->memberofcallcentreque = $memberofcallcentreque;
  return $this;
 }
 
 public function getMailbox() {
  return $this->mailbox;
 }
 
 public function setMailbox($mailbox) {
  $this->mailbox = $mailbox;
  return $this;
 }
 
 public function getCallsequence() {
  return $this->callsequence;
 }
 
 public function setCallsequence($callsequence) {
  $this->callsequence = $callsequence;
  return $this;
 }
 
 public function getNumberStatus() {
  return $this->number_status;
 }
 
 public function setNumberStatus($number_status) {
  $this->number_status = $number_status;
  return $this;
 }
 
 public function getPeertype() {
  return $this->peertype;
 }
 
 public function setPeertype($peertype) {
  $this->peertype = $peertype;
  return $this;
 }
 
 public function getDiversionUnconditionalStatus() {
  return $this->diversion_unconditional_status;
 }
 
 public function setDiversionUnconditionalStatus($diversion_unconditional_status) {
  $this->diversion_unconditional_status = $diversion_unconditional_status;
  return $this;
 }
 
 public function getDiversionUnconditionalNumber() {
  return $this->diversion_unconditional_number;
 }
 
 public function setDiversionUnconditionalNumber($diversion_unconditional_number) {
  $this->diversion_unconditional_number = $diversion_unconditional_number;
  return $this;
 }
 
 public function getDiversionUnavailStatus() {
  return $this->diversion_unavail_status;
 }
 
 public function setDiversionUnavailStatus($diversion_unavail_status) {
  $this->diversion_unavail_status = $diversion_unavail_status;
  return $this;
 }
 
 public function getDiversionUnavailNumber() {
  return $this->diversion_unavail_number;
 }
 
 public function setDiversionUnavailNumber($diversion_unavail_number) {
  $this->diversion_unavail_number = $diversion_unavail_number;
  return $this;
 }
 
 public function getDiversionBusyStatus() {
  return $this->diversion_busy_status;
 }
 
 public function setDiversionBusyStatus($diversion_busy_status) {
  $this->diversion_busy_status = $diversion_busy_status;
  return $this;
 }
 
 public function getDiversionBusyNumber() {
  return $this->diversion_busy_number;
 }
 
 public function setDiversionBusyNumber($diversion_busy_number) {
  $this->diversion_busy_number = $diversion_busy_number;
  return $this;
 }
 
 public function getDiversionNoanswerStatus() {
  return $this->diversion_noanswer_status;
 }
 
 public function setDiversionNoanswerStatus($diversion_noanswer_status) {
  $this->diversion_noanswer_status = $diversion_noanswer_status;
  return $this;
 }
 
 public function getDiversionNoanswerNumber() {
  return $this->diversion_noanswer_number;
 }
 
 public function setDiversionNoanswerNumber($diversion_noanswer_number) {
  $this->diversion_noanswer_number = $diversion_noanswer_number;
  return $this;
 }
  
 public function getDiversionUnconditionalLandingtype() {
  return $this->diversion_unconditional_landingtype;
 }
 
 public function setDiversionUnconditionalLandingtype($diversion_unconditional_landingtype) {
  $this->diversion_unconditional_landingtype = $diversion_unconditional_landingtype;
  return $this;
 }
 
 public function getDiversionBusyLandingtype() {
  return $this->diversion_busy_landingtype;
 }
 
 public function setDiversionBusyLandingtype($diversion_busy_landingtype) {
  $this->diversion_busy_landingtype = $diversion_busy_landingtype;
  return $this;
 }
 
 public function getDiversionNoanswerLandingtype() {
  return $this->diversion_noanswer_landingtype;
 }
 
 public function setDiversionNoanswerLandingtype($diversion_noanswer_landingtype) {
  $this->diversion_noanswer_landingtype = $diversion_noanswer_landingtype;
  return $this;
 }
 
 public function getDiversionUnavailLandingtype() {
  return $this->diversion_unavail_landingtype;
 }
 
 public function setDiversionUnavailLandingtype($diversion_unavail_landingtype) {
  $this->diversion_unavail_landingtype = $diversion_unavail_landingtype;
  return $this;
 }
public function setDiversionNoanswerDuration($diversion_noanswer_duration)
  {
  	$this->diversion_noanswer_duration = $diversion_noanswer_duration;
  	return $this;
  } 
public function getDiversionNoanswerDuration()
    {
    	return $this->diversion_noanswer_duration;
    }
public function getExtensionRecord()
{
	return $this->extensionrecord;
}
    
public function setExtensionrecord($extensionrecord)
{
	$this->extensionrecord = $extensionrecord;
	return $this;
}
public function getVpbxid()
{
    return $this->vpbxid;
}
public function setVpbxid($vpbxid)
{
    $this->vpbxid = $vpbxid;
    return $this;
}

 }
