<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionInterface;

interface RingingMohDialOptionDialOptionInterface extends DialOptionInterface
{
    function getMohClass();    
    function setMohClass($mohClass);
}