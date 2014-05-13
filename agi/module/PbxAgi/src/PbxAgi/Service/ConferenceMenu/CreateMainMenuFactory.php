<?php
namespace PbxAgi\Service\ConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Service\ConferenceMenu\CreateMainMenu;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateMainMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $buildCreateConferenceMenu = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildCreateConferenceMenu');
        $buildPasswordCreateMenu = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\CreateConferencePasswordMenu\BuildPasswordCreateMenu');
        $nodeController = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\NodeController');
        $buildHangupNode = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\Hangup\BuildHangupNode');
        $buildConferencePromtScopeMenu = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\CreateConferenceMenu\BuildConferencePromptScopeMenu');
        return new CreateMainMenu(
        		  $buildCreateConferenceMenu, 
        		  $buildPasswordCreateMenu, 
        		  $nodeController,
				  $buildHangupNode,
                  $buildConferencePromtScopeMenu
				);
    }
}