<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptionsContextExtensionInterface; 
use PbxAgi\DialDescriptor\AbstractDialOptionsParametrizedContextExtension;

class ExecExtenAfterCallerHangupDialOption extends AbstractDialOptionsParametrizedContextExtension 
implements DialOptionsContextExtensionInterface
{        
    const IDENTIFIER = 'F';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
       
}