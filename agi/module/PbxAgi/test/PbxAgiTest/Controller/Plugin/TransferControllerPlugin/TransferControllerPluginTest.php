<?php
namespace PbxAgiTest\Controller\Plugin\TransferControllerPlugin;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\Plugin\TransferControllerPluginFactory;

class TransferControllerPluginTest extends PHPUnit_Framework_TestCase
{
	protected $recordCallControllerPlugin;
	protected $mockedVarManager;	
	protected $transferControllerPlugin;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         

        $mockedVarManager = $this->getMockBuilder('PbxAgi\Service\ChannelVarManager\ChannelVarManager')
        ->disableOriginalConstructor()
        ->getMock();
         
        $serviceManager->setService('ChannelVarManager', $mockedVarManager);
        $this->mockedVarManager = $mockedVarManager;
        
        $factory = new TransferControllerPluginFactory($serviceManager);

        $this->transferControllerPlugin = $factory->createService($serviceManager);
        
      
    }
    public function testTransferControllerPluginSetContextSuccessfully()
    {
	   $this->mockedVarManager->expects($this->once())
    		 ->method('setTransferContext')
    		 ->will($this->returnValue(null));  
	  $this->assertNull($this->transferControllerPlugin->__invoke());
    }
}