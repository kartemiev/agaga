<?php
namespace PbxAgi\Service\ShortDialMenu\GotoShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class ShiftCursorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $shortDialTable = $serviceLocator->get('PbxAgi\ShortDial\Model\ShortDialTable');
        $call = $serviceLocator->get('CallEntity');
        $playCurrentItem = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\PlayCurrentItem');
        $nodeController = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\NodeController');
        $cursorContainer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer');
        return new ShiftCursor($cursorContainer, $shortDialTable, $call, $playCurrentItem, $nodeController);
    }
}