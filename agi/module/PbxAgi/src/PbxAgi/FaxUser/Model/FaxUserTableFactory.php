<?php
namespace PbxAgi\FaxUser\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\FaxUser\Model\FaxUserTable;

class FaxUserTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('PbxAgi\FaxUser\Model\FaxUserTableGateway');
        return new FaxUserTable($tableGateway);
    }    
}