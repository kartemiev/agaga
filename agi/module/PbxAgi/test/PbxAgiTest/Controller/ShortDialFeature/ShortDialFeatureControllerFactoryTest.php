<?php
namespace PbxAgiTest\Controller\ShortDialFeature;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\ShortDialFeatureControllerFactory;


class ShortDialFeatureControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $shortDialFeatureController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new ShortDialFeatureControllerFactory();
                
        $this->shortDialFeatureController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofShortDialFeatureController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\ShortDialFeatureController', $this->shortDialFeatureController);
    }
}