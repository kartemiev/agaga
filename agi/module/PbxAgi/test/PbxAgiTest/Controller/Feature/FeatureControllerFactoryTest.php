<?php
namespace PbxAgiTest\Controller\Feature;
use \PbxAgiTest\Bootstrap;
use PbxAgi\Controller\FeatureControllerFactory;
use PHPUnit_Framework_TestCase;


class FeatureControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $featureController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new FeatureControllerFactory();
                
        $this->featureController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofFeatureController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\FeatureController', $this->featureController);
    }
}