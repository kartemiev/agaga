<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferenceMenu;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BuildConferencePromptScopeMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new BuildConferencePromptScopeMenu(
        		$serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildGenericNode'), 
        		$serviceLocator->get('AppConfig'), 
         		$serviceLocator->get('PbxAgi\Service\Closurize'),
        		$serviceLocator->get('PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer')       		
 			);
    }
}