<?php
namespace PbxAgiTest\ChannelDescriptor\Model;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\ChannelDescriptor\ChannelDescriptorParseError;


class ChannelDescriptorParseErrorTest extends PHPUnit_Framework_TestCase
{   
    public function testChannelDesriptorParserErrorInitialState()
    {
    	$channeldescriptorparseerror = new ChannelDescriptorParseError();    
    	$this->assertNull($channeldescriptorparseerror->code, '"code" should initially be null');
    	$this->assertNull($channeldescriptorparseerror->message, '"message" should initially be null');
    }
    
    public function testSettersAndGettersPerformCorrectly()
    {
    	$channeldescriptorparseerror = new ChannelDescriptorParseError();    
        $filter = new UnderscoreToCamelCase();
        
    	foreach ($channeldescriptorparseerror as $propertyname=>$propertyvalue)
    	{
    	    $methodNameMutator = 'set'. $filter($propertyname);
    	    $methodNameAccessor = 'get'. $filter($propertyname);
    	    
     	    if (!method_exists($channeldescriptorparseerror, $methodNameMutator))
    	    {
    	    	throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    	    }
    	    if (!method_exists($channeldescriptorparseerror, $methodNameAccessor))
    	    {
   	    	   throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    	    }
    		call_user_func(array($channeldescriptorparseerror,$methodNameMutator),'test');
    		$result = call_user_func(array($channeldescriptorparseerror,$methodNameAccessor));
            $this->assertSame($result, 'test');    		
     	}
    }
    
}