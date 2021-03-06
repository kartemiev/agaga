<?php
namespace PbxAgi\Service\ConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class NodeControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {        
        $agi = $serviceLocator->get('ClientImpl');
        $nodeController = $agi->createNodeController('app');
        return $nodeController;
    }
}