<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class RingingIndicationBristuffDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'R';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}