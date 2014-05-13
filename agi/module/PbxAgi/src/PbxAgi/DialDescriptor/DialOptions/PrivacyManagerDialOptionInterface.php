<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionInterface;

interface PrivacyManagerDialOptionInterface extends DialOptionInterface
{
    function getDatabase();    
    function setDatabase($database);
}