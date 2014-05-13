<?php
namespace PbxAgi\Service\ShortDialMenu\CreateShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\ShortDialNumChosen;

class ShortDialNumChosenFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $nodeController = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\NodeController');
        $shortDialDataContainer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\ShortDialDataContainer');        
        return new ShortDialNumChosen($nodeController, $shortDialDataContainer);
    }
}