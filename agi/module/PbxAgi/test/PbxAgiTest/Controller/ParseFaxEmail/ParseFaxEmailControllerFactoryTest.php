<?php
namespace PbxAgiTest\Controller\ParseFaxEmail;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\ParseFaxEmailControllerFactory;


class ParseFaxEmailControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $parseFaxEmailController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new ParseFaxEmailControllerFactory();
                
        $this->parseFaxEmailController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofParseFaxEmailController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\ParseFaxEmailController', $this->parseFaxEmailController);
    }
}