<?php
namespace Vpbxui\CallCentreSchedule\Model;


interface TimeSpotTableInterface
{
    function fetchaAll($filter = null, $limit = null, $offset = null);
    function queryResultCount($filter = null); 
}