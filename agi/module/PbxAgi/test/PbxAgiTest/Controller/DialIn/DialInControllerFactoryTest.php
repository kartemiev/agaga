<?php
namespace PbxAgiTest\Controller\DialIn;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\DialInControllerFactory;


class DialInControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $dialInController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new DialInControllerFactory();
                
        $this->dialInController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofDialInController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\DialInController', $this->dialInController);
    }
}