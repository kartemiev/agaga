<?php
namespace PbxAgiTest\Service\ShortDialMenu;
 
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\ShortDialMenu\CreateMainMenuFactory;   


class MainMenuTest extends PHPUnit_Framework_TestCase
{
    private $nodeController;
    private $mockedAppConfig;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $serviceManager->setAllowOverride(true);
        
        $appConfig =  $serviceManager->get('AppConfig');
        
        
        $mockedAppConfig = $this->getMockBuilder('PbxAgi\Service\AppConfig\AppConfigService')
        ->disableOriginalConstructor()
        ->getMock();
        
        $this->mockedAppConfig = $mockedAppConfig;
        $serviceManager->setService('AppConfig', $mockedAppConfig);
        
        
        $mockedAppConfig->expects($this->any())
        ->method('getShortDialMainMenuPrompt')
        ->with()
        ->will($this->returnValue(true));
        
        
        
        
        $factory = new CreateMainMenuFactory();
        $mainMenu = $factory->createService($serviceManager);
        $this->nodeController = $mainMenu->getNodeController();
        $mainMenu->__invoke();         
        $cursorContainer = $serviceManager->get('PbxAgi\Service\ShortDialMenu\IndexShortDialMenu\CursorContainer');
        $cursorContainer->id = 100;        
    }
    public function testSettersAndGettersPerformCorrectly()
    {
        $this->nodeController->jumpTo('mainMenu');        
     }
     
}