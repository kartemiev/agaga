<?php
namespace Vpbxui\OperatorStatusLog\Model;

use Vpbxui\OperatorStatusLog\Model\OperatorStatusLog;

interface OperatorStatusLogTableInterface
{
    const OPERATORSTATUS_ABSENT = 'ABSENT';
    const OPERATORSTATUS_DELETED = 'DELETED';
    
    function addEntry(OperatorStatusLog $logentry);
}