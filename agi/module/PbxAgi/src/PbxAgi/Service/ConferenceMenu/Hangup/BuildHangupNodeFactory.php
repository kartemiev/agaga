<?php
namespace PbxAgi\Service\ConferenceMenu\Hangup;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\Hangup\BuildHangupNode;

class BuildHangupNodeFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)    
    {
        return new BuildHangupNode(
         		$serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildGenericNode'),    
        		$serviceLocator->get('PbxAgi\Service\Closurize'),        
        		$serviceLocator->get('PbxAgi\Service\ConferenceMenu\Hangup\HangupCommand')
		);
    }
}