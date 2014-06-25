<?php
namespace Vpbxui\PbxSettings\Model;

use Vpbxui\PbxSettings\Model\PbxSettings;

interface PbxSettingsTableInterface
{
   function fetchAll();   
   function savePbxSettings(PbxSettings $pbxsettings);    
   function getPbxSettings($vpbxid);    
}