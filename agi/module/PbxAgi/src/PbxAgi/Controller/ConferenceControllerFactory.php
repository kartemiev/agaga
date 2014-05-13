<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\ConferenceController;

class ConferenceControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{	    
	    $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new ConferenceController(
	       $sl->get('ClientImpl'),
		   $sl->get('CallEntity'),
		   $sl->get('ChannelVarManager'),
		   $sl->get('PbxAgi\Service\ConferenceMenu\JoinMainMenu'),
		   $sl->get('PbxAgi\Service\ConferenceMenu\CreateMainMenu')		    
		);
	}
}