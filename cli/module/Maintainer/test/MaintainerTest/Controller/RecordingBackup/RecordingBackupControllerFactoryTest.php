<?php
namespace MaintainerTest\Controller\RecordingBackup;

use \MaintainerTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use Maintainer\Controller\RecordingBackupControllerFactory;

class RecordingBackupControllerFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $recordingBackupController;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new RecordingBackupControllerFactory();
                
        $this->recordingBackupController = $factory->createService($serviceManager);        
    }
    public function testFactoryReturnsInstanceofRecordingBackupController()
    {
    	$this->setUp();
        $this->assertInstanceOf('Maintainer\Controller\RecordingBackupController', $this->recordingBackupController);
    }
}