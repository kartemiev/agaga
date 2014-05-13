<?php
namespace Vpbxui\Conference\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Conference\Model\ConferenceTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConferenceTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $conferenceTableGateway = $serviceLocator->get('Vpbxui\Conference\Model\ConferenceTableGateway');
        return new ConferenceTable($conferenceTableGateway);
    }
}
