<?php
namespace Saas\Did\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DidTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $apiGateway = $serviceLocator->get('Saas\Did\Model\DidTableGateway');
       return new DidTable($apiGateway);
    }
}