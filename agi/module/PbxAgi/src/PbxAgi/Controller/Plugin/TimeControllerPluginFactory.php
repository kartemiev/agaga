<?php
namespace PbxAgi\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\Plugin\TimeControllerPlugin;

class TimeControllerPluginFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	return new TimeControllerPlugin(
	       $serviceLocator->get('PbxAgi\CallCentreStatus\Model\CallCentreStatusTable')
    	);
    }
	
}