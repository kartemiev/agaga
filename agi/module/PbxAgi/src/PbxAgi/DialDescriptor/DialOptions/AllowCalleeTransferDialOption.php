<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AllowCalleeTransferDialOption extends AbstractDialOption
{
    const IDENTIFIER = 't';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}