<?php
namespace Vpbxui\ExtensionGroupProfile\Model;

use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfile;

interface ExtensionGroupProfileTableInterface
{

    function fetchAll($filter=null);    
    
    function getExtensionGroupProfile($id);    
         
    function saveExtensionGroupProfile(ExtensionGroupProfile $extensionGroupProfile);
    
    function deleteExtensionGroupProfile($id);
}