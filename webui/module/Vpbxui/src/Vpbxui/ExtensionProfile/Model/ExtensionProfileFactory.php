<?php
namespace Vpbxui\ExtensionProfile\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\ExtensionProfile\Model\ExtensionProfile;

class ExtensionProfileFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');        
        $extensionprofile = new ExtensionProfile($dbAdapter);
        return $extensionprofile;        
    }
}