<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\CreateShortDial;

class CreateShortDialFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $shortDialTable = $serviceLocator->get('PbxAgi\ShortDial\Model\ShortDialTable');
        $agi = $serviceLocator->get('ClientImpl');
        $appConfig = $serviceLocator->get('AppConfig');
        $call = $serviceLocator->get('CallEntity');
        $shortDialDataContainer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\ShortDialDataContainer');
         $nodeController = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\NodeController');
          
        return new CreateShortDial(
            $shortDialTable, 
            $agi, 
            $appConfig, 
            $call, 
            $shortDialDataContainer, 
            $nodeController 
             );
    }
}