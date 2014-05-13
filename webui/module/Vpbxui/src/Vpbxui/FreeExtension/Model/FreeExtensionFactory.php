<?php
namespace Vpbxui\FreeExtension\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\FreeExtension\Model\FreeExtension;

class FreeExtensionFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');        
        $freeExtension = new FreeExtension($dbAdapter);
        return $freeExtension;        
    }
}