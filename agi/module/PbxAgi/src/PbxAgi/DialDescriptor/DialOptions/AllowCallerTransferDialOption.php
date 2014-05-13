<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AllowCallerTransferDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'T';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
}