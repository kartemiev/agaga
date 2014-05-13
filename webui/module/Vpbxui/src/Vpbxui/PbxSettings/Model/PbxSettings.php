<?php
namespace Vpbxui\PbxSettings\Model;

class PbxSettings
{
  public  $callcentre_status_override;  
  protected  $dbAdapter;
   
  public function exchangeArray($data)
  {
       if (isset($data['callcentre_status_override']))  $this->callcentre_status_override = $data['callcentre_status_override'];      
  }
   
}