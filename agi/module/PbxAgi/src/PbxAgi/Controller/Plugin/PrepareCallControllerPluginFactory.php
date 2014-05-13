<?php
namespace PbxAgi\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\Plugin\PrepareCallControllerPlugin;

class PrepareCallControllerPluginFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl =  (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new PrepareCallControllerPlugin(
               $sl->get('CallEntity'),
                $sl->get('ChannelVarManager')            
            
               );
    }
}
