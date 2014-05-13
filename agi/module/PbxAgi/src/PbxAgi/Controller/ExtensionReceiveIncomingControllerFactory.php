<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\ExtensionReceiveIncomingController;

class ExtensionReceiveIncomingControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new ExtensionReceiveIncomingController(
                $sl->get('ClientImpl'),
                $sl->get('ExtensionTable'),
                $sl->get('AppConfig'),
                $sl->get('ChannelVarManager'),
                $sl->get('CallEntity'),
        		$sl->get('PbxAgi\CallDestination\Model\CallDestinationTable'),
        		$sl->get('PbxAgi\DialDescriptor\DialOptionsDescriptor')            
                );
    }
}
 