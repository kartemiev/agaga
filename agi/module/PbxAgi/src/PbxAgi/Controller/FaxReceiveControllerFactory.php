<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\FaxReceiveController;

class FaxReceiveControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;        
        return new FaxReceiveController(
        		$sl->get('ExtensionTable'),
        		$sl->get('PbxAgi\FaxSpool\Model\FaxSpoolTable'),
        		$sl->get('ChannelVarManager'),
        		$sl->get('AppConfig'),
        		$sl->get('ClientImpl')
				);
    }
}
