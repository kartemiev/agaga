<?php
namespace Vpbxui\FaxUserEmail\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\FaxUserEmail\Model\FaxUserEmailTable;

class FaxUserEmailTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\FaxUserEmail\Model\FaxUserEmailTableGateway');
        return new FaxUserEmailTable($tableGateway);
    }    
}