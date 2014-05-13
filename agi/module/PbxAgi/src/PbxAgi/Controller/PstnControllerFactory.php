<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\PstnController;

class PstnControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;;;
         return new PstnController(
                $sl->get('PbxAgi\Service\RouteBuilder\RouteBuilder'),
                $sl->get('ClientImpl'),
                 $sl->get('AppConfig'),
         		 $sl->get('PbxAgi\Service\SkypeAliasResolver\SkypeAliasResolver'),
         		 $sl->get('PbxAgi\DialDescriptor\DialOptionsDescriptor'),
         		 $sl->get('ChannelVarManager')
             
                 );
    }
}
