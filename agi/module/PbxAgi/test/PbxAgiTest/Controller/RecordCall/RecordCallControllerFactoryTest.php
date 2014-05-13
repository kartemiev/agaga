<?php
namespace PbxAgiTest\Controller\RecordCall;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\RecordCallControllerFactory;

class RecordCallControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $recordCallController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new RecordCallControllerFactory();
                
        $this->recordCallController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofRecordCallController()
    {
    	$this->setUp();
        $this->assertInstanceOf('PbxAgi\Controller\RecordCallController', $this->recordCallController);
    }
}