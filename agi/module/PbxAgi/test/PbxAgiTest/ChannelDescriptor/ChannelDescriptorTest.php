<?php
namespace PbxAgiTest\ChannelDescriptor\Model;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\ChannelDescriptor\ChannelDescriptor;


class ChannelDescriptorTest extends PHPUnit_Framework_TestCase
{   
    public function testChannelDesriptorInitialState()
    {
    	$channeldescriptor = new ChannelDescriptor();    
    	$this->assertNull($channeldescriptor->peername, '"peername" should initially be null');
    	$this->assertNull($channeldescriptor->technology, '"technology" should initially be null');
    	$this->assertNull($channeldescriptor->uniqueid, '"uniqueid" should initially be null');
    }
    
    public function testSettersAndGettersPerformCorrectly()
    {
        $channeldescriptor = new ChannelDescriptor();
        $filter = new UnderscoreToCamelCase();
        
    	foreach ($channeldescriptor as $propertyname=>$propertyvalue)
    	{
    	    $methodNameMutator = 'set'. $filter($propertyname);
    	    $methodNameAccessor = 'get'. $filter($propertyname);
    	    
     	    if (!method_exists($channeldescriptor, $methodNameMutator))
    	    {
    	    	throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    	    }
    	    if (!method_exists($channeldescriptor, $methodNameAccessor))
    	    {
   	    	   throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    	    }
    		call_user_func(array($channeldescriptor,$methodNameMutator),'test');
    		$result = call_user_func(array($channeldescriptor,$methodNameAccessor));
            $this->assertSame($result, 'test');    		
     	}
    }
    
}
