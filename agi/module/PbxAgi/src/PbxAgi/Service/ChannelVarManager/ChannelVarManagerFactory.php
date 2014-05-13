<?php
namespace PbxAgi\Service\ChannelVarManager;

use PbxAgi\Service\ChannelVarManager\ChannelVarManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ChannelVarManagerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new ChannelVarManager($serviceLocator->get('ClientImpl'),$serviceLocator->get('CallEntity'));
    }
}
 