<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class CallerHangupStarKeyDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'H';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}