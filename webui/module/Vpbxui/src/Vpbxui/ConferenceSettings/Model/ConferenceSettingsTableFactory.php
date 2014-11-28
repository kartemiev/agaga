<?php
namespace Vpbxui\ConferenceSettings\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConferenceSettingsTableFactory implements FactoryInterface
{     
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
          return new ConferenceSettingsTable(
                $serviceLocator->get('Vpbxui\ConferenceSettings\Model\ConferenceSettingsTableGateway')
             );
    }
}
