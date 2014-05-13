<?php
namespace PbxAgiTest\Controller\Plugin\RecordCallControllerPlugin;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Controller\Plugin\RecordCallControllerPluginFactory;
use PAGI\Client\Impl\MockedClientImpl;

class RecordCallControllerPluginTest extends PHPUnit_Framework_TestCase
{
	protected $recordCallControllerPlugin;
	protected $mockedAgi;	
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
                 
        $this->mockedAgi = new MockedClientImpl(array());
        $serviceManager->setService('ClientImpl', $this->mockedAgi);
        
        
        $factory = new RecordCallControllerPluginFactory();
                
        $this->recordCallControllerPlugin = $factory->createService($serviceManager);        
        
    }
    public function testRecordCallControllerPluginSetsCdrFieldCorrectly()
    {
    	$recordCallControllerPlugin = $this->recordCallControllerPlugin;    

    	$mockedAgi = $this->mockedAgi;
    	$mockedAgi
    		->assert('getVariable',array('HANGUPCAUSE'))
    		->assert('getVariable',array('RECORD_FILENAME'))    		
    		->onGetVariable(true,'16')
    		->onGetVariable(true,'394894894848998')
    	 	->addMockedResult('200 result=0');     	     	
    	$this->recordCallControllerPlugin->updateCDR();
    }
}