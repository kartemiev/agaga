<?php
namespace PbxAgi\Service\ShortDialMenu\ModifyShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\ModifyShortDialMenu\BuildModifyShortDialMenu;
 
class BuildModifyShortDialMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator){
        $shortDialDstValidator = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\ShortDialDstValidator');
        $createShortDial = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\CreateShortDial');
        $instance = new BuildModifyShortDialMenu($shortDialDstValidator, $createShortDial);
        $initializer = $serviceLocator->get('PbxAgi\Service\BuildAbstractMenu\BuildAbstractMenuInitializer');
        $initializer->initialize($instance, $serviceLocator);
        return $instance;
    }
}