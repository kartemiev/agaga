<?php
namespace PbxAgi\Service\ConferenceMenu;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Service\ConferenceMenu\JoinMainMenu;

class JoinMainMenuFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $agi = $serviceLocator->get('ClientImpl');
        $nodecontroller = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\NodeController');
        $buildConferenceMenu = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\EnterConferenceMenu\BuildConferenceMenu');
        $buildPasswordMenu = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\EnterConferencePasswordMenu\BuildPasswordMenu');
        $buildHangupNode = $serviceLocator->get('PbxAgi\Service\ConferenceMenu\Hangup\BuildHangupNode');
        
        return new JoinMainMenu($agi, $nodecontroller, $buildConferenceMenu, $buildPasswordMenu, $buildHangupNode);
    }    
}