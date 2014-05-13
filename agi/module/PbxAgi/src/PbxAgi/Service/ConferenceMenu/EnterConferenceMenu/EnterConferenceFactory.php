<?php
namespace PbxAgi\Service\ConferenceMenu\EnterConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\EnterConference;

class EnterConferenceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $agi = $serviceLocator->get('ClientImpl');
        $conferenceTable = $serviceLocator->get('PbxAgi\Conference\Model\ConferenceTable');
        $conferenceCredentialsContainer = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer');
        $hangupAndQuit = $serviceLocator->get('PbxAgi\Service\ClientImpl\HangupAndQuit');       
        $nodeController = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\NodeController'); 
        $callEntity = $serviceLocator->get('CallEntity');        
        $appConfig = $serviceLocator->get('AppConfig');
        return new EnterConference(
        			$agi, 
        			$conferenceTable, 
        			$conferenceCredentialsContainer, 
        			$hangupAndQuit, 
        			$nodeController, 
        			$callEntity, 
        			$appConfig
				);
    }
}