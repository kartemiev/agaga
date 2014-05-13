<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AllowCallingCallParkDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'K';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}