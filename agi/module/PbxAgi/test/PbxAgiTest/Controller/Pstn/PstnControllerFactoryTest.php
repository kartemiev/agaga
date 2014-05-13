<?php
namespace PbxAgiTest\Controller\Pstn;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\PstnControllerFactory;

class PstnControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $pstnController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new PstnControllerFactory();
                
        $this->pstnController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofPstnController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\PstnController', $this->pstnController);
    }
}