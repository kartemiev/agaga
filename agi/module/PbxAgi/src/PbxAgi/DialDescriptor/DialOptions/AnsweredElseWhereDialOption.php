<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class AnsweredElseWhereDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'c';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }    
}