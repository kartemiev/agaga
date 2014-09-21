<?php
namespace Vpbxui\Extension\Model;

use Vpbxui\Extension\Model\Extension;

interface ExtensionTableInterface
{
    const EXTENSION_TYPE_REGULAR = 'regular';
    const EXTENSION_TYPE_OPERATOR = 'operator';
    function fetchAll($filter=null);  
    function fetchDistinctExtensions($limit);
    function getExtension($id);
    function saveExtension(Extension $extension);
    function deleteExtension($id);
    function getOperatorList();
    function getNextFreeExtension();    
    function deleteAllExtensions();
    
}