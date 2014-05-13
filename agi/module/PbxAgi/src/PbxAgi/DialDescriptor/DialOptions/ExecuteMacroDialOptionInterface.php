<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionInterface;

interface ExecuteMacroDialOptionInterface extends DialOptionInterface
{
    function getMacroName();    
    function setMacroName($macroName);
}