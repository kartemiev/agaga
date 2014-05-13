<?php
namespace PbxAgi\TrunkDestination\Model;

use PbxAgi\TrunkDestination\Model\TrunkDestination;

interface TrunkDestinationTableInterface
{
    function fetchAll($filter=null);    
	
}