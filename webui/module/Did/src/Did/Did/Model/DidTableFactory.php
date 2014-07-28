<?php
namespace Did\Did\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DidTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $apiGateway = $serviceLocator->get('Did\Did\Model\DidTableGateway');
       return new DidTable($apiGateway);
    }
}