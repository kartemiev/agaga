<?php
namespace Saas\TempMedia\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TempMediaTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Saas\TempMedia\Model\TempMediaTableGateway');
        return new TempMediaTable($tableGateway);
    }    
}