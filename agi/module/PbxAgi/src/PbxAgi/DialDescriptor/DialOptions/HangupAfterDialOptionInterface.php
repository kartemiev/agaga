<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionInterface;
interface HangupAfterDialOptionInterface extends DialOptionInterface
{    
    function getTimeout();    
    function setTimeout($timeout);
}