<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class JumpNextPriorityAfterConnectDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'g';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}