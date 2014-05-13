<?php
namespace Vpbxui\FaxUser\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\FaxUser\Model\FaxUserTable;

class FaxUserTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\FaxUser\Model\FaxUserTableGateway');
        return new FaxUserTable($tableGateway);
    }    
}