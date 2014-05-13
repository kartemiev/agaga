<?php
namespace PbxAgi\Service\CdrManager;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\CdrManager\CdrManager;

class CdrManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $agi = $serviceLocator->get('ClientImpl');
        return new CdrManager($agi);
    }
    
}