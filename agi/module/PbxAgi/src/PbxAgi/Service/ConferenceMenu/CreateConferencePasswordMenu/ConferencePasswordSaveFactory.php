<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConferencePasswordSaveFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $conferenceCredentialsContainer = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer');        
        return new ConferencePasswordSave($conferenceCredentialsContainer);
    }
}