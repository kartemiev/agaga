<?php
namespace PbxAgi\Service\ConferenceMenu\EnterConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\BuildConferenceMenu;

class BuildConferenceMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $conferenceValidator = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\ConferenceValidator');
        $enterConference = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\EnterConference');
        $createConference = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\CreateConference');
        $closurize = $serviceLocator->get('PbxAgi\Service\Closurize');
        $appConfig = $serviceLocator->get('AppConfig');
        $hangupAndQuit = $serviceLocator->get('PbxAgi\Service\ClientImpl\HangupAndQuit'); 
        $buildGenericNode = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildGenericNode');
        
        return new BuildConferenceMenu($conferenceValidator, 
            $enterConference, $createConference, $closurize, $appConfig, $hangupAndQuit, $buildGenericNode);
    }
}