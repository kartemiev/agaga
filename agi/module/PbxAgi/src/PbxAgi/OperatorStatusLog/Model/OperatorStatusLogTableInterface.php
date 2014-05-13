<?php
namespace PbxAgi\OperatorStatusLog\Model;

use PbxAgi\OperatorStatusLog\Model\OperatorStatusLogInterface;

interface OperatorStatusLogTableInterface {
    function addEntry(OperatorStatusLogInterface $operatorStatusLog);
}