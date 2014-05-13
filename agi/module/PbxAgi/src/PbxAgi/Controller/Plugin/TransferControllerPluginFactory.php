<?php
namespace PbxAgi\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Controller\Plugin\TransferControllerPlugin;

class TransferControllerPluginFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        
        $channelVarManager = $sl->get('ChannelVarManager');
        return new TransferControllerPlugin($channelVarManager);
    } 
}