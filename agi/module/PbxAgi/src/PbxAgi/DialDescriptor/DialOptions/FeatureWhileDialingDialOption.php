<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class FeatureWhileDialingDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'd';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}