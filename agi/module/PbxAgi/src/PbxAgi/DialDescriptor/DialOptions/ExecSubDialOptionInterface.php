<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionInterface;

interface ExecSubDialOptionInterface extends DialOptionInterface
{
    function getSubName();    
    function setSubName($subName);
}