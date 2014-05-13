<?php
namespace PbxAgiTest\Service\ConferenceMenu;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\ConferenceMenu\JoinMainMenuFactory;

class JoinMainMenuFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $joinMainMenu;
 	public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new JoinMainMenuFactory();
                
        $this->joinMainMenu = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofJoinMainMenu()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Service\ConferenceMenu\JoinMainMenu', $this->joinMainMenu);
    }
}