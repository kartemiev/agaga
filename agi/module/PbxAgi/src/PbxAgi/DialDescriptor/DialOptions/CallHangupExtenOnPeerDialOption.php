<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOption;

class CallHangupExtenOnPeerDialOption extends AbstractDialOption
{
    const IDENTIFIER = 'e';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }    
}