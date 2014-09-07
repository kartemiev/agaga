<?php
namespace RestfulTest\Controller\VpbxEnv;

use \RestfulTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Restful\Controller\VpbxEnvControllerFactory;
 
class VpbxEnvControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $vpbxEnvController;
	public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new VpbxEnvControllerFactory();
                
        $this->vpbxEnvController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofVpbxEnvController()
    {
    	$this->setUp();
        $this->assertInstanceOf('Restful\Controller\VpbxEnvController', $this->vpbxEnvController);
    }
}