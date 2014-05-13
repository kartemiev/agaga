<?php
namespace PbxAgiTest\Controller\Plugin\FeatureCheckPermissionPlugin;
use \PbxAgiTest\Bootstrap;
use PbxAgi\Controller\Plugin\FeatureCheckPermissionPluginFactory;
use PHPUnit_Framework_TestCase;

class FeatureCheckPermissionPluginFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $featureCheckPermissionPlugin;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new FeatureCheckPermissionPluginFactory();
                
        $this->featureCheckPermissionPlugin = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofNodecontroller()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\Plugin\FeatureCheckPermissionPlugin', $this->featureCheckPermissionPlugin);       
    }
}