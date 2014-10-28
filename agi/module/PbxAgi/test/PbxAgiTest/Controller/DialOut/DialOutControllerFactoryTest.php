<?php
namespace PbxAgiTest\Controller\DialOut;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\DialOutControllerFactory;


class DialOutControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $dialOutController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);
                          
        $factory = new DialOutControllerFactory();
                
        $this->dialOutController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofDialOutController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\DialOutController', $this->dialOutController);
    }
}