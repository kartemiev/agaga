<?php
namespace Vpbxui\Conference\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Conference\Model\ConferenceTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConferenceTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ConferenceTable(
                $serviceLocator->get('Vpbxui\Conference\Model\ConferenceTableGateway'),
                $serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidProvider')
            );
    }
}
