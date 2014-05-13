<?php
namespace PbxAgi\Service\ConferenceMenu\CreateConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\NewConferenceNumberValidator;

class NewConferenceNumberValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $conferenceValidator = $serviceLocator->get('PbxAgi\Conference\Model\ConferenceValidator');
         return new NewConferenceNumberValidator($conferenceValidator);
    }
}