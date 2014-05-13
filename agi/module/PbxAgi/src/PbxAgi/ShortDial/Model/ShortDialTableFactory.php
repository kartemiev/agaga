<?php
namespace PbxAgi\ShortDial\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\ShortDial\Model\ShortDialTable;

class ShortDialTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $shortdialtablegateway = $serviceLocator->get('PbxAgi\ShortDial\Model\ShortDialTableGateway');
        return  new ShortDialTable($shortdialtablegateway);
    }
}
