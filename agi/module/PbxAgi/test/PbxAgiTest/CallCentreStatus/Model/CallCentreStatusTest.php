<?php
namespace PbxAgiTest\CallCentreStatus\Model;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use PbxAgi\CallCentreStatus\Model\CallCentreStatus;

class CallCentreStatusTest extends PHPUnit_Framework_TestCase
{
    public function testCallCentreStatusInitialState()
    {
    	$callcentrestatus = new CallCentreStatus();    
    	$this->assertNull($callcentrestatus->statutory, '"statutory" should initially be null');
    	$this->assertNull($callcentrestatus->overridestatus, '"overridestatus" should initially be null');
    	$this->assertNull($callcentrestatus->status, '"status" should initially be null');
    }
    
    public function testExchangeArraySetsPropertiesCorrectly()
    {
    	$callcentrestatus = new CallCentreStatus();
    	$data  = array('statutory' => true,
    			'overridestatus'     => true,
    			'status'  => true);
    
    	$callcentrestatus->exchangeArray($data);
    
    	$this->assertSame($data['statutory'], $callcentrestatus->statutory, '"statutory" was not set correctly');
    	$this->assertSame($data['overridestatus'], $callcentrestatus->overridestatus, '"overridestatus" was not set correctly');
    	$this->assertSame($data['status'], $callcentrestatus->status, '"status" was not set correctly');
    }
    
    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
    	$callcentrestatus = new CallCentreStatus();
    
    	$callcentrestatus->exchangeArray(array(
    	        'statutory' => true,
    			'overridestatus'     => true,
    			'status'  => true));
    	$callcentrestatus->exchangeArray(array());
    
    	$this->assertNull($callcentrestatus->statutory, '"statutory" should have defaulted to null');
    	$this->assertNull($callcentrestatus->overridestatus, '"overridestatus" should have defaulted to null');
    	$this->assertNull($callcentrestatus->status, '"status" should have defaulted to null');
    }
    
    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
    	$callcentrestatus = new CallCentreStatus();
    	$data  = array('statutory' => true,
    			       'overridestatus'     => true,
    			       'status'  => true
    	               );
    
    	$callcentrestatus->exchangeArray($data);
    	$copyArray = $callcentrestatus->getArrayCopy();
    
    	$this->assertSame($data['statutory'], $copyArray['statutory'], '"statutory" was not set correctly');
    	$this->assertSame($data['overridestatus'], $copyArray['overridestatus'], '"overridestatus" was not set correctly');
    	$this->assertSame($data['status'], $copyArray['status'], '"status" was not set correctly');
    }
    
}