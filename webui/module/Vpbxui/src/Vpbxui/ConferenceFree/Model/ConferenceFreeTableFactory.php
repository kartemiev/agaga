<?php
namespace Vpbxui\ConferenceFree\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\ConferenceFree\Model\ConferenceFreeTable;

class ConferenceFreeTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $conferenceFreeTableGateway = $serviceLocator->get('Vpbxui\ConferenceFree\Model\ConferenceFreeTableGateway');
        return new ConferenceFreeTable($conferenceFreeTableGateway);
    }
}
