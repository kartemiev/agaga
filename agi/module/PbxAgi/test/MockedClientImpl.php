<?php
namespace PbxAgiTest;

use PAGI\Client\Impl\MockedClientImpl as MockedBase;
use PbxAgi\Service\ClientImpl\ClientImplInterface;
 

class MockedClientImpl extends MockedBase implements ClientImplInterface {
    public function getPeer();
    public function streamMultiple()
    {
        
    }
    public function fatal_handler()
    {
        
    }
    public function streamSilence($seconds,$escapeDigits)
    {}
}
 