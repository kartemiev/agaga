<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionsParametrizedContextExtension;
use PbxAgi\DialDescriptor\DialOptionsContextExtensionInterface;

class PostConnectDialPlanTransferBothToDialOption extends AbstractDialOptionsParametrizedContextExtension implements DialOptionsContextExtensionInterface
{
    const IDENTIFIER = 'G';
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}