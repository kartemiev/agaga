<?php
namespace Saas\FreeDid\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FreeDidTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $apiGateway = $serviceLocator->get('Saas\FreeDid\Model\FreeDidTableGateway');
       return new FreeDidTable($apiGateway);
    }
}