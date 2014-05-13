<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\AlarmController;

class AlarmControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
	    $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new AlarmController(
		    $sl->get('PbxAgi\Service\CallSpoolImpl\CallSpoolImpl'),
		    $sl->get('ClientImpl'),   
		    $sl->get('PbxAgi\Validator\Time\SimpleTimeWithoutSemicolumnValidator'),      
		    $sl->get('AppConfig'),
		    $sl->get('PbxAgi\Service\DialString\SimpleTimeParser'),
		    $sl->get('PbxAgi\GenericWrappers\DateTime'),
		    $sl->get('ChannelVarManager')		    
        );		
	}
}