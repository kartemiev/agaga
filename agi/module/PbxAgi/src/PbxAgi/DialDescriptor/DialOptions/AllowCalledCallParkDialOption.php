<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AllowCalledCallParkDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'k';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}