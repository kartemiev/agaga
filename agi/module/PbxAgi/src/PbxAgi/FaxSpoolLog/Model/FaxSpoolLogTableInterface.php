<?php
namespace PbxAgi\FaxSpoolLog\Model;

use PbxAgi\FaxSpoolLog\Model\FaxSpoolLog;

interface FaxSpoolLogTableInterface
{
    function saveLogEntry(FaxSpoolLog $faxspoollog);
    function updateResult(FaxSpoolLog $faxspoollog);    
}