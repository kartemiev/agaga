<?php
namespace PbxAgi\Service\ShortDialMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ShortDialMenu\CreateMainMenu;

class CreateMainMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $nodeController  = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\NodeController');
        $buildIndexShortDialMenu = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\BuildIndexShortDialMenu');
        $buildCreateShortDialMenu = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildCreateShortDialMenu'); 
        $buildMainMenu = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\MainMenu\BuildMainMenu');
        $buildDeleteShortDialMenu = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\DeleteShortDialMenu\BuildDeleteShortDialMenu');
        $buildConfirmSaveShortDialMenu  = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildConfirmSaveShortDialMenu');        
        $buildGotoShortDialMenu = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\GotoShortDialMenu\BuildGotoShortDialMenu');
        $buildModifyShortDialMenu = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\ModifyShortDialMenu\BuildModifyShortDialMenu');
        $buildPromptNewAliasNumMenu = $serviceLocator->get('PbxAgi\Service\ShortDialMenu\CreateShortDialMenu\BuildPromptNewAliasNumMenu');
        
         return new CreateMainMenu(
            $nodeController, 
            $buildIndexShortDialMenu, 
            $buildCreateShortDialMenu, 
            $buildMainMenu,
            $buildDeleteShortDialMenu,
            $buildConfirmSaveShortDialMenu,
            $buildGotoShortDialMenu,
            $buildModifyShortDialMenu,
         	$buildPromptNewAliasNumMenu
             );
    }
}