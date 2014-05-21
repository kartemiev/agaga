<?php
namespace AgiHelperTest\Controller\ProcessRecorded;

use \AgiHelperTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use AgiHelper\Controller\ProcessRecordedControllerFactory;
 
class ProcessRecordedControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $processRecordedController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new ProcessRecordedControllerFactory();
                
        $this->processRecordedController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofProcessRecordedController()
    {
    	$this->setUp();
        $this->assertInstanceOf('AgiHelper\Controller\ProcessRecordedController', $this->processRecordedController);
    }
}