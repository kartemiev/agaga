<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\BuildPasswordCreateMenu;
use Zend\ServiceManager\ServiceLocatorInterface;

class BuildPasswordCreateMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $closurize = $serviceLocator->get('PbxAgi\Service\Closurize');    
        $conferencePasswordSave = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\ConferencePasswordSave');    
        $buildGenericNode = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildGenericNode');
        $appConfig = $serviceLocator->get('AppConfig');
        $newConferencePinValidator = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\NewConferencePinValidator');
        return new BuildPasswordCreateMenu($closurize, 
            $conferencePasswordSave, 
            $buildGenericNode, 
            $appConfig, 
            $newConferencePinValidator
            );
    }
}