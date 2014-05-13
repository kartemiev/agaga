<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AllowCalleeAutomixerDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'x';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}