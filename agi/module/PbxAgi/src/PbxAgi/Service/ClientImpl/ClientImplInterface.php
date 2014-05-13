<?php
namespace PbxAgi\Service\ClientImpl;

use PAGI\Client\IClient;

interface ClientImplInterface extends IClient
{

    const MONITOR_OPTION_RECORD_WHEN_BRIDGED = 'b';

    function fatal_handler();
    // function getInstance(array $options = array());
 
    function StreamMultiple($files, $escapeDigits);

    function StreamSilence($seconds, $escapeDigits);
}