<?php
namespace SaasTest\Controller\CreateVpbxEnv;
use \SaasTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Saas\Controller\CreateVpbxEnvControllerFactory;
 
class CreateVpbxEnvControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $createVpbxEnvController;
	public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new CreateVpbxEnvControllerFactory();
                
        $this->createVpbxEnvController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofCreateVpbxEnvController()
    {
    	$this->setUp();
        $this->assertInstanceOf('Saas\Controller\CreateVpbxEnvController', $this->createVpbxEnvController);
    }
}