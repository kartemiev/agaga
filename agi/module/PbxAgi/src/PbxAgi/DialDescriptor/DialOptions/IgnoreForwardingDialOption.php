<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class IgnoreForwardingDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'i';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}