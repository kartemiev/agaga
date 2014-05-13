<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Controller\OperatorPresenceFeatureController;
use Zend\ServiceManager\ServiceLocatorInterface;


class OperatorPresenceFeatureControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $sl =(method_exists($serviceLocator, 'getServiceLocator')) ? 
                $serviceLocator->getServiceLocator():
            $serviceLocator;       
         return new OperatorPresenceFeatureController( 
                 $sl->get('ChannelVarManager'),
                 $sl->get('CallEntity'),
                 $sl->get('OperatorTable'),
                 $sl->get('ClientImpl'),
                 $sl->get('OperatorStatusLogTable'),
                 $sl->get('OperatorStatusLog'),
                 $sl->get('AppConfig')
                 );
    }
}