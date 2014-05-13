<?php
namespace PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\ConferencePasswordValidator;

class ConferencePasswordValidatorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
      $conferenceCredentialsContainer = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainer');
      return new ConferencePasswordValidator($conferenceCredentialsContainer);
    }
}
