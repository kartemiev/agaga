<?php
namespace PbxAgiTest\Service\ConferenceMenu;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\ConferenceMenu\CreateMainMenuFactory;

class CreateMainMenuFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $createMainMenu;
 	public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new CreateMainMenuFactory();
                
        $this->createMainMenu = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofCreateMainMenu()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Service\ConferenceMenu\CreateMainMenu', $this->createMainMenu);
    }
}