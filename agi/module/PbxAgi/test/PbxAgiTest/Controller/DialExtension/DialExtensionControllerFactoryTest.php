<?php
namespace PbxAgiTest\Controller\DialExtension;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\DialExtensionControllerFactory;

class DialExtensionControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $dialExtensionController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new DialExtensionControllerFactory();
                
        $this->dialExtensionController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofDialExtensionController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\DialExtensionController', $this->dialExtensionController);
    }
}