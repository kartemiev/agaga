<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionInterface;

interface AnnouncementDialOptionInterface extends DialOptionInterface
{
    function getFilename();   
    function setFilename($filename);     
}