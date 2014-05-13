<?php
namespace PbxAgi\Service\CallSpoolImpl;

use PAGI\CallSpool\Impl\CallSpoolImpl;

class CallSpoolImplFactory
{ 
    public function getInstance($options)
    {
        return CallSpoolImpl::getInstance($options);        
    }
}