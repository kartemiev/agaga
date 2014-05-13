<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class ScreeningModeDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'p';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }    
}