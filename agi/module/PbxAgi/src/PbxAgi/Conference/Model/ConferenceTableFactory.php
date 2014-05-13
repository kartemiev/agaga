<?php
namespace PbxAgi\Conference\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Conference\Model\ConferenceTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConferenceTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $conferenceTableGateway = $serviceLocator->get('PbxAgi\Conference\Model\ConferenceTableGateway');
        return new ConferenceTable($conferenceTableGateway);
    }
}
