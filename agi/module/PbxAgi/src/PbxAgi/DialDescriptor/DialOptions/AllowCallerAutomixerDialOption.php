<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AllowCallerAutomixerDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'X';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }    
}