<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class RingingIndicationDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'r';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }    
}