<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionInterface;

interface LimitCallWithWarningDialOptionInterface extends DialOptionInterface
{
    function getLimitTime();   
    function getWarningTime();
    function getRepeatFreqency();    
    function setLimitTime($limitTime);    
    function setWarningTime($warningTime);
    function setRepeatFreqency($repeatFreqency);    
}