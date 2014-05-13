<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class DisableCallScreeningDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'N';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}
