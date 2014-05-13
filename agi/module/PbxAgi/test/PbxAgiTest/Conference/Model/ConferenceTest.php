<?php
namespace PbxAgiTest\Conference\Model;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use PbxAgi\CallDestination\Model\CallDestination;
use Zend\Filter\Word\UnderscoreToCamelCase;


class ConferenceTest extends PHPUnit_Framework_TestCase
{
    public function testCallDestinationInitialState()
    {
    	$calldestination = new CallDestination();    
    	$this->assertNull($calldestination->peerid, '"peerid" should initially be null');
    	$this->assertNull($calldestination->number, '"number" should initially be null');
    	$this->assertNull($calldestination->duration, '"duration" should initially be null');
    }
    
    public function testExchangeArraySetsPropertiesCorrectly()
    {
    	$calldestination = new CallDestination();
    	$data  = array(
    	               'peerid' => '0001',
    			       'number'     => '84956408040',
    			       'duration'  => 30
    	           );
    
    	$calldestination->exchangeArray($data);
    
    	$this->assertSame($data['peerid'], $calldestination->peerid, '"peerid" was not set correctly');
    	$this->assertSame($data['number'], $calldestination->number, '"number" was not set correctly');
    	$this->assertSame($data['duration'], $calldestination->duration, '"duration" was not set correctly');
    }
    
    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
    	$calldestination = new CallDestination();
    
    	$calldestination->exchangeArray(
    	           array(
    	               'peerid' => '0001',
    			       'number'     => '84956408040',
    			       'duration'  => 30)
    	           );
    	$calldestination->exchangeArray(array());
    
    	$this->assertNull($calldestination->peerid, '"peerid" should have defaulted to null');
    	$this->assertNull($calldestination->number, '"number" should have defaulted to null');
    	$this->assertNull($calldestination->duration, '"duration" should have defaulted to null');
    }
    
    public function testSettersAndGettersPerformCorrectly()
    {
        $calldestination = new CallDestination();
        $filter = new UnderscoreToCamelCase();
        
    	foreach ($calldestination as $propertyname=>$propertyvalue)
    	{
    	    $methodNameMutator = 'set'. $filter($propertyname);
    	    $methodNameAccessor = 'get'. $filter($propertyname);
    	    
     	    if (!method_exists($calldestination, $methodNameMutator))
    	    {
    	    	throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    	    }
    	    if (!method_exists($calldestination, $methodNameAccessor))
    	    {
   	    	   throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    	    }
    		call_user_func(array($calldestination,$methodNameMutator),'test');
    		$result = call_user_func(array($calldestination,$methodNameAccessor));
            $this->assertSame($result, 'test');    		
     	}
    }
    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
    	$calldestination = new CallDestination();
    	$data  = array('peerid' => '0001',
    			       'number'     => '84956408040',
    			       'duration'  => 30
    	               );
    
    	$calldestination->exchangeArray($data);
    	$copyArray = $calldestination->getArrayCopy();
    
    	$this->assertSame($data['peerid'], $copyArray['peerid'], '"peerid" was not set correctly');
    	$this->assertSame($data['number'], $copyArray['number'], '"number" was not set correctly');
    	$this->assertSame($data['duration'], $copyArray['duration'], '"duration" was not set correctly');
    }
    
}