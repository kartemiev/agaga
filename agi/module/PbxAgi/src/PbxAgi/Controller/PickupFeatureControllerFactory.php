<?php
namespace PbxAgi\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\PickupFeatureController;

class PickupFeatureControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $sl =(method_exists($serviceLocator, 'getServiceLocator')) ? 
                $serviceLocator->getServiceLocator():
            $serviceLocator;       
         return new PickupFeatureController( 
          		 $sl->get('ClientImpl')
                 );
    }
}