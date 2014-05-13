<?php
namespace PbxAgiTest\Service\RouteBuilderTest;
use \PbxAgiTest\Bootstrap;
use PbxAgi\Service\RouteBuilder\RouteBuilderFactory;
use PHPUnit_Framework_TestCase;


class RouteBuilderFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $routeBuilder;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new RouteBuilderFactory();
                
        $this->routeBuilder = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofNodecontroller()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Service\RouteBuilder\RouteBuilder', $this->routeBuilder);       
    }
}