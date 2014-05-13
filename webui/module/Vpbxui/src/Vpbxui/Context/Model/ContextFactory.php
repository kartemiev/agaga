<?php
namespace Vpbxui\Context\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Context\Model\Context;

class ContextFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        return new Context($dbAdapter);
    }
}