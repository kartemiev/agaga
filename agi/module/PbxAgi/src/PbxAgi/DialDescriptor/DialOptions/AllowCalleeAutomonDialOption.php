<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AllowCalleeAutomonDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'w';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}