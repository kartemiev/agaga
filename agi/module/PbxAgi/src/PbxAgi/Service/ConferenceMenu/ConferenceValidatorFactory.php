<?php
namespace PbxAgi\Service\ConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Service\ConferenceMenu\ConferenceValidator;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConferenceValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $conferenceValidator = $serviceLocator->get('PbxAgi\Conference\Model\ConferenceValidator');
         return new ConferenceValidator($conferenceValidator);
    }
}