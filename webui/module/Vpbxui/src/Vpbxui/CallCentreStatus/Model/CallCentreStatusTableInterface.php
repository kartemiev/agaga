<?php
namespace Vpbxui\CallCentreStatus\Model;

interface CallCentreStatusTableInterface
{
    function fetchAll($filter=null);
}