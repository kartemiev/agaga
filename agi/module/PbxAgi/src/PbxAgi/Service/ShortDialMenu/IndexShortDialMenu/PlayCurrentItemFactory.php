<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\PlayCurrentItem;

class PlayCurrentItemFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $cursorContainer = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer');
        $agi = $serviceLocator->get('ClientImpl');
        $shortDialTable = $serviceLocator->get('PbxAgi\ShortDial\Model\ShortDialTable');
        return new PlayCurrentItem($cursorContainer, $agi, $shortDialTable);
    }
}