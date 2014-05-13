<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionInterface;

interface PostConnectDtmfDialOptionInterface extends DialOptionInterface
{
    function getDigits();
    function setDigits($digits);
}