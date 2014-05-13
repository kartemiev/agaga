<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildCreateConferenceMenu;

class BuildCreateConferenceMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $buildGenericNode = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildGenericNode'); 
        $appConfig = $serviceLocator->get('AppConfig');
        $newConferenceNumberValidator = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\NewConferenceNumberValidator');
        $closurize = $serviceLocator->get('PbxAgi\Service\Closurize');
        $hangupAndQuit = $serviceLocator->get('PbxAgi\Service\ClientImpl\HangupAndQuit');
        $createConference = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\CreateConference');
        return new BuildCreateConferenceMenu(
                        $buildGenericNode, 
                        $appConfig, 
                        $newConferenceNumberValidator, 
                        $closurize, $hangupAndQuit, 
                        $createConference
            );
    }   
}