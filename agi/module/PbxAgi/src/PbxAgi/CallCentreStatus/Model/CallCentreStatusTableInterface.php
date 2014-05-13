<?php
namespace PbxAgi\CallCentreStatus\Model;

interface CallCentreStatusTableInterface
{
    function fetchAll($filter=null);
}