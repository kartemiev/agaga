<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;
 
class ResetCDRDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'C';    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}