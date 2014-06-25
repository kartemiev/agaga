<?php
namespace Vpbxui\PbxSettings\Model;

class PbxSettings
{
  public  $callcentre_status_override;  
  public $vpbxid;
  protected  $dbAdapter;
   
  public function exchangeArray($data)
  {
       $this->callcentre_status_override =  (isset($data['callcentre_status_override'])) ?$data['callcentre_status_override']:null;              
  }
   
  
  
  public function getCallcentreStatusOverride()
  {
  	return $this->callcentre_status_override;
  }
  public function setCallcentreStatusOverride($callcentreStatusOverride)
  {
  	 $this->callcentre_status_override = $callcentreStatusOverride;
  	 return $this;
  }
  public function getVpbxid()
  {
  	return  $this->vpbxid;
  }
  public function setVpbxid($vpbxid)
  {
  	$this->vpbxid = $vpbxid;
  	return $this;
  }
  
}