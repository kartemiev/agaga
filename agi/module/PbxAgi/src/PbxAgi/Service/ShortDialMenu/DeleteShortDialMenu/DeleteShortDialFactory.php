<?php
namespace PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu\DeleteShortDial;

class DeleteShortDialFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $nodeController = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\NodeController');
        $agi = $serviceLocator->get('ClientImpl');        
        $appConfig  = $serviceLocator->get('AppConfig');
        $cursorContainer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer');
        $shortDialTable = $serviceLocator->get('PbxAgi\ShortDial\Model\ShortDialTable');
        return new DeleteShortDial($nodeController, $agi, $appConfig, $cursorContainer, $shortDialTable);
    }
}