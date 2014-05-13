<?php
namespace PbxAgi\Service\BuildAbstractMenu;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\InitializerInterface;
 
class BuildAbstractMenuInitializer implements InitializerInterface
{
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
       $closurize = $serviceLocator->get('PbxAgi\Service\Closurize');
       $hangupAndQuit = $serviceLocator->get('PbxAgi\Service\ClientImpl\HangupAndQuit');
       $appConfig = $serviceLocator->get('AppConfig');
       $buildGenericNode = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildGenericNode');
       $instance->setClosurize($closurize);
       $instance->setAppConfig($appConfig);
       $instance->setHangupAndQuit($hangupAndQuit);
       $instance->setBuildGenericNode($buildGenericNode);
    }
   
}