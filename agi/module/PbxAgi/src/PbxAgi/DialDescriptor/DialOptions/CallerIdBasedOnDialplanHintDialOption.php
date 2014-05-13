<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class CallerIdBasedOnDialplanHintDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'f';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}