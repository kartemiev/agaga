<?php
namespace PbxAgi\Extension\Model;
use PbxAgi\Extension\Model\Extension;

interface ExtensionTableInterface
{
	function fetchAll($filter = null, $limit = null);	
    function getExtension($extension);
    function isValid($extension);
    function getFaxExtension();
    function getExtensionById($id);    
    function updateExtensionUnconditionalForward(Extension $extension);
}