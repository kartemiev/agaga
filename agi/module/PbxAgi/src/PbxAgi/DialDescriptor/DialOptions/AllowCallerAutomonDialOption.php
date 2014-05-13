<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AllowCallerAutomonDialOption extends AbstractDialOption
{
     
    const IDENTIFIER = 'W';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}