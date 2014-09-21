<?php
namespace Vpbxui\TrunkDestination\Model;

use Vpbxui\TrunkDestination\Model\TrunkDestination;

interface TrunkDestinationTableInterface
{
    function fetchAll($filter=null);
        
    function saveTrunkDestination(TrunkDestination $trunkdestination);
    
    function deleteTrunkDestinationAll($route);
    
    function deleteAllTrunkDestinations();
   
}