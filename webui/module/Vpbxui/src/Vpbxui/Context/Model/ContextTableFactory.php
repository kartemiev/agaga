<?php
namespace Vpbxui\Context\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Context\Model\ContextTable;

class ContextTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $tableGateway = $serviceLocator->get('Vpbxui\Context\Model\ContextTableGateway');
       return new ContextTable($tableGateway);
    }
}