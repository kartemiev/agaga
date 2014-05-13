<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\DialOutController;
  
class DialOutControllerFactory implements FactoryInterface {
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl  = (method_exists($serviceLocator, 'getServiceLocator'))?
                $serviceLocator->getServiceLocator():
            $serviceLocator;        
        return new DialOutController(
                $sl->get('AppConfig'), 
                $sl->get('ClientImpl'), 
                 $sl->get('ChannelVarManager'),
            $sl->get('PbxAgi\ShortDial\Model\ShortDialTable')
                );
    }    
}
