<?php
namespace PbxAgiTest\Model\Context;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\Context\Model\Context;


class ContextTest extends PHPUnit_Framework_TestCase
{
    public function testContextInitialState()
    {
    	$context = new Context();    
    	$this->assertNull($context->id, '"id" should initially be null');
    	$this->assertNull($context->custname, '"custname" should initially be null');
    	$this->assertNull($context->custdesc, '"custdesc" should initially be null');
    	$this->assertNull($context->contexttype, '"contexttype" should initially be null');
    	$this->assertNull($context->internalref, '"internalref" should initially be null');
    	$this->assertNull($context->ivrref, '"ivrref" should initially be null');
    	$this->assertNull($context->funcref, '"funcref" should initially be null');    	 
    }
    
    public function testExchangeArraySetsPropertiesCorrectly()
    {
    	$context = new Context();
    	$data  = array(
    	               'id' => 1,
    	    'custname'     => 'IVR Тест',
    	    'custdesc'     => '',
    	    'contexttype'     => 'IVR',
    	    'internalref'     => 1,
    	    'ivrref'     => 1,
    	    'funcref'     => 1
    	           );
    
    	$context->exchangeArray($data);
    
    	$this->assertSame($data['id'], $context->id, '"id" was not set correctly');
    	$this->assertSame($data['custname'], $context->custname, '"custname" was not set correctly');
    	$this->assertSame($data['custdesc'], $context->custdesc, '"custdesc" was not set correctly');
    	$this->assertSame($data['contexttype'], $context->contexttype, '"contexttype" was not set correctly');
    	$this->assertSame($data['internalref'], $context->internalref, '"internalref" was not set correctly');
    	$this->assertSame($data['ivrref'], $context->ivrref, '"ivrref" was not set correctly');
    	$this->assertSame($data['funcref'], $context->funcref, '"funcref" was not set correctly');    	 
    }
    
    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
    	$context = new Context();
    
    	$context->exchangeArray(
                array(
    	               'id' => 1,
    	    'custname'     => 'IVR Тест',
    	    'custdesc'     => '',
    	    'contexttype'     => 'IVR',
    	    'internalref'     => 1,
    	    'ivrref'     => 1,
    	    'funcref'     => 1
    	           )    	           
    	       );
    	$context->exchangeArray(array());
   
    	$this->assertNull($context->id, '"peerid" should have defaulted to null');
    	$this->assertNull($context->custname, '"number" should have defaulted to null');
    	$this->assertNull($context->custdesc, '"duration" should have defaulted to null');
    	$this->assertNull($context->contexttype, '"contexttype" should have defaulted to null');
    	$this->assertNull($context->internalref, '"internalref" should have defaulted to null');
    	$this->assertNull($context->ivrref, '"ivrref" should have defaulted to null');
    	$this->assertNull($context->funcref, '"funcref" should have defaulted to null');
    	 
    }
    
    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
    	$context = new Context();
    	$data  = array(
    	               'id' => 1,
    	    'custname'     => 'IVR Тест',
    	    'custdesc'     => '',
    	    'contexttype'     => 'IVR',
    	    'internalref'     => 1,
    	    'ivrref'     => 1,
    	    'funcref'     => 1
    	           );  
    
    	$context->exchangeArray($data);
    	$copyArray = $context->getArrayCopy();
    
    	$this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
    	$this->assertSame($data['custname'], $copyArray['custname'], '"custname" was not set correctly');
    	$this->assertSame($data['custdesc'], $copyArray['custdesc'], '"duration" was not set correctly');
    	$this->assertSame($data['contexttype'], $copyArray['contexttype'], '"contexttype" was not set correctly');
    	$this->assertSame($data['internalref'], $copyArray['internalref'], '"internalref" was not set correctly');
    	$this->assertSame($data['ivrref'], $copyArray['ivrref'], '"ivrref" was not set correctly');
    	$this->assertSame($data['funcref'], $copyArray['funcref'], '"funcref" was not set correctly');    	 
    }
    
}