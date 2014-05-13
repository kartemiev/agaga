<?php
namespace PbxAgiTest\Controller\FaxReceive;
use \PbxAgiTest\Bootstrap;
use PbxAgi\Controller\FaxReceiveControllerFactory;
use PHPUnit_Framework_TestCase;


class FaxControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $faxController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new FaxReceiveControllerFactory();
                
        $this->faxController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofFaxController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\FaxReceiveController', $this->faxController);
    }
}