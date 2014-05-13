<?php
namespace Vpbxui\Extension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Extension\Model\Extension;

class ExtensionFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');        
        $extension = new Extension($dbAdapter);
        return $extension;        
    }
}