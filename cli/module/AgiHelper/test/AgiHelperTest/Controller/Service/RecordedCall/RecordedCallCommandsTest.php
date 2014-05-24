<?php
namespace AgiHelper\Service\RecordedCall;
use \AgiHelperTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use AgiHelper\Service\RecordedCall\RecordedCallCommandsFactory;
use \Mockery as m;

function filesize($path) {
	return RecordedCallCommandsTest::$functions->filesize($path);
}

function exec($cmd) {
	return RecordedCallCommandsTest::$functions->exec($cmd);
}

class RecordedCallCommandsTest extends PHPUnit_Framework_TestCase
{
	public static $functions;	
	protected $recordedCallCommands;
	protected $mockedAppConfig;
    public function setUp()
    {
    	self::$functions = m::mock();    	 
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
        
        $this->mockedAppConfig = $this->getMockBuilder('AgiHelper\Service\AppConfig\AppConfigService')
        									  ->disableOriginalConstructor()
        									  ->getMock();
        
        $serviceManager->setService('AgiHelper\Service\AppConfig\AppConfigService', $this->mockedAppConfig);
        
        $factory = new RecordedCallCommandsFactory();
        
        $this->recordedCallCommands = $factory->createService($serviceManager);
                
    }
    public function tearDown() {
    	m::close();
    }
    
    public function testConvertPerformsCorrectlyAndReturnsTrue()
    {
    	$mockedAppConfig = $this->mockedAppConfig;
    	$mockedAppConfig->expects($this->once())->method('getMediareposDir')
    						    ->will($this->returnValue('/var/spool/asterisk/mediarepos'));
    	$mockedAppConfig->expects($this->once())->method('getMediaConverterPath')
    						    ->will($this->returnValue('/usr/bin/lame'))    						
    					;
    	self::$functions->shouldReceive('exec')->with('/usr/bin/lame -b16 "/tmp/01234567890" "/var/spool/asterisk/mediarepos/01234567890.mp3"')->once();
    	self::$functions->shouldReceive('filesize')->with('/var/spool/asterisk/mediarepos/01234567890.mp3')->once();
    	$this->recordedCallCommands->setSrcMedia('/tmp/01234567890');
    	$this->recordedCallCommands->convert('01234567890');	 
    }
}