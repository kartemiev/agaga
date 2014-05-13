<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class SendOriginalCallerIdDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'o';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}