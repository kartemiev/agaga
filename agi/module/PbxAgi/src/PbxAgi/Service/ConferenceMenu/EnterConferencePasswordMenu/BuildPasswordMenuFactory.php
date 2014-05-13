<?php
namespace PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\BuildPasswordMenu;
use Zend\ServiceManager\ServiceLocatorInterface;

class BuildPasswordMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)    
    {
        $nodeController = $serviceLocator->get('Pbxagi\Service\ConferenceMenu\NodeController');
        $conferencePasswordValidator = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\ConferencePasswordValidator');
        $appConfig = $serviceLocator->get('AppConfig');
        $hangupAndQuit = $serviceLocator->get('PbxAgi\Service\ClientImpl\HangupAndQuit');   
        $buildGenericNode = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildGenericNode');        
        $closurize = $serviceLocator->get('PbxAgi\Service\Closurize');        
        return new BuildPasswordMenu($nodeController, $conferencePasswordValidator, $appConfig, $hangupAndQuit, $buildGenericNode, $closurize);
    }
}