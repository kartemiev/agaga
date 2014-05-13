<?php
namespace PbxAgiTest\ChannelDescriptor\Model;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\ChannelDescriptor\ChannelDescriptorParser;
use PbxAgi\ChannelDescriptor\ChannelLocalDescriptor;
use PbxAgi\ChannelDescriptor\ChannelDescriptor;

class ChannelDescriptorParserTest extends PHPUnit_Framework_TestCase
{   
    protected $channelDescriptorParser;
    public function setUp()
    {

        $serviceManager = Bootstrap::getServiceManager();
        $serviceManager->setAllowOverride(true);
        $channelDescriptorParser = $serviceManager->get('PbxAgi\ChannelDescriptor\ChannelDescriptorParser');
        $this->channelDescriptorParser = $channelDescriptorParser;        
    }
    public function testCanSuccessfullyParseLocalPattern()
    {
        $channelLocalDescriptor = new ChannelLocalDescriptor();
        $channelLocalDescriptor->technology = 'Local';
        $channelLocalDescriptor->context = 'context';
        $channelLocalDescriptor->extension = '100';
        $channelLocalDescriptor->uniqueid = '123';
        $channelLocalDescriptor->sequence = null;
        
        $result = $this->channelDescriptorParser->parse('Local/100@context-123;456','local channel descriptor pattern parser should have returned same data');
        
    	$this->assertTrue($channelLocalDescriptor==$result);
    }
    public function testInvalidParserInputReturnsInstanceOfChannelDescriptorParseError()
    {
    	$result = $this->channelDescriptorParser->parse('somemeaninglessstuffhere');    
    	$this->assertInstanceOf('PbxAgi\ChannelDescriptor\ChannelDescriptorParseError', $result);
    }
    public function testCanSuccessfullyParseDoublePattern()
    {
    	$channelDescriptor = new ChannelDescriptor();
        $channelDescriptor->peername = '100';
        $channelDescriptor->technology = 'SIP';
        $channelDescriptor->uniqueid = '123';
    	$result = $this->channelDescriptorParser->parse('SIP/100-123','double channel descriptor pattern parser should have returned same data');
    
    	$this->assertTrue($channelDescriptor==$result);
    }
    public function testGetServiceLocatorReturnsServiceLocatorInstance()
    {
    	$this->assertInstanceOf('Zend\ServiceManager\ServiceLocatorInterface', $this->channelDescriptorParser->getServiceLocator());
    }
}
