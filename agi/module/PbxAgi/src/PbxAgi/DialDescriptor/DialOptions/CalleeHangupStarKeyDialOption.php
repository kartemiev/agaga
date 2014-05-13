<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class CalleeHangupStarKeyDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'h';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}
