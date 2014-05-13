<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\CreateConference;

class CreateConferenceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $nodeController = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\NodeController');
        $conferenceTable = $serviceLocator->get('PbxAgi\Conference\Model\ConferenceTable');
        $agi = $serviceLocator->get('ClientImpl');
        $hangupAndQuit = $serviceLocator->get('PbxAgi\Service\ClientImpl\HangupAndQuit');
        $call = $serviceLocator->get('CallEntity');
        $conferenceCredentialsContainer = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer');        
        return new CreateConference($nodeController, $conferenceTable, $agi, $hangupAndQuit, $call, $conferenceCredentialsContainer);
    }
}