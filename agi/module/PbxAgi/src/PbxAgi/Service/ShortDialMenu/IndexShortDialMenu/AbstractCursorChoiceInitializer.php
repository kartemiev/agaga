<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class AbstractCursorChoiceInitializer implements InitializerInterface
{
    public function initialize(
        $instance, 
        ServiceLocatorInterface $serviceLocator
        )
    {
        $agi = $serviceLocator->get('ClientImpl');
        $appConfig = $serviceLocator->get('AppConfig');
        $cursorContaner = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer');
        $shortDialTable = $serviceLocator->get('PbxAgi\ShortDial\Model\ShortDialTable');
        $playCurrentItem = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\PlayCurrentItem');
        $nodeController = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\NodeController');
        $call = $serviceLocator->get('CallEntity');
        $instance->setAgi($agi);
        $instance->setAppConfig($appConfig);
        $instance->setCursorContainer($cursorContaner);
        $instance->setShortDialTable($shortDialTable);
        $instance->setPlayCurrentItem($playCurrentItem);
        $instance->setCall($call);
    }
}