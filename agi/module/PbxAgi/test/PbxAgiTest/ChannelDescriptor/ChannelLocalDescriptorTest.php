<?php
namespace PbxAgiTest\ChannelLocalDescriptor\Model;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\ChannelDescriptor\ChannelLocalDescriptor;


class ChannelLocalDescriptorTest extends PHPUnit_Framework_TestCase
{    
    public function testChannelLocalDesriptorInitialState()
    {
    	$channellocaldescriptor = new ChannelLocalDescriptor();    
    	$this->assertNull($channellocaldescriptor->technology, '"technology" should initially be null');
    	$this->assertNull($channellocaldescriptor->uniqueid, '"uniqueid" should initially be null');
    	$this->assertNull($channellocaldescriptor->extension, '"extension" should initially be null');
    	$this->assertNull($channellocaldescriptor->sequence, '"sequence" should initially be null');
    }
    
    
    public function testSettersAndGettersPerformCorrectly()
    {
        $channellocaldescriptor = new ChannelLocalDescriptor();
        $filter = new UnderscoreToCamelCase();
        
    	foreach ($channellocaldescriptor as $propertyname=>$propertyvalue)
    	{
    	    $methodNameMutator = 'set'. $filter($propertyname);
    	    $methodNameAccessor = 'get'. $filter($propertyname);
    	    
     	    if (!method_exists($channellocaldescriptor, $methodNameMutator))
    	    {
    	    	throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    	    }
    	    if (!method_exists($channellocaldescriptor, $methodNameAccessor))
    	    {
   	    	   throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    	    }
    		call_user_func(array($channellocaldescriptor,$methodNameMutator),'test');
    		$result = call_user_func(array($channellocaldescriptor,$methodNameAccessor));
            $this->assertSame($result, 'test');    		
     	}
    }
    
}
