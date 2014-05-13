<?php
namespace PbxAgi\Context\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Context\Model\ContextTable;

class ContextTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $tableGateway = $serviceLocator->get('PbxAgi\Context\Model\ContextTableGateway');
       return new ContextTable($tableGateway);
    }
}