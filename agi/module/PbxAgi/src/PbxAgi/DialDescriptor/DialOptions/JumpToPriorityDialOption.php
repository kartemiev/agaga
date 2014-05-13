<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class JumpToPriorityDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'j';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}