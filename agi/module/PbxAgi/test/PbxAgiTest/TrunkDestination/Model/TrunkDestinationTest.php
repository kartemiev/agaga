<?php
namespace PbxAgiTest\TrunkDestination\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\TrunkDestination\Model\TrunkDestination;

class TrunkDestinationTest extends PHPUnit_Framework_TestCase
{
    public function testTrunkDestinationInitialState()
    {
        $trunkdestination = new TrunkDestination();
        $this->assertNull($trunkdestination->trunkref, '"trunkref" should initially be null');
        $this->assertNull($trunkdestination->numbermatchref, '"numbermatchref" should initially be null');
        $this->assertNull($trunkdestination->routeref, '"routeref" should initially be null');       
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $trunkdestination = new TrunkDestination();
        $data  = array(        		
     					'trunkref'=> 197,
    					'numbermatchref'=> 21,
    					'routeref'=> 10          
        				);

        $trunkdestination->exchangeArray($data);

         $this->assertSame($data['trunkref'], $trunkdestination->trunkref, '"trunkref" was not set correctly');
         $this->assertSame($data['numbermatchref'], $trunkdestination->numbermatchref, '"numbermatchref" was not set correctly');
         $this->assertSame($data['routeref'], $trunkdestination->routeref, '"routeref" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $trunkdestination = new TrunkDestination();

        $trunkdestination->exchangeArray(array(
     					'trunkref'=> 197,
    					'numbermatchref'=> 21,
    					'routeref'=> 10      		 
            ));
        $trunkdestination->exchangeArray(array());
    
        $this->assertNull($trunkdestination->trunkref, '"trunkref" should have defaulted to null');
        $this->assertNull($trunkdestination->numbermatchref, '"numbermatchref" should have defaulted to null');
        $this->assertNull($trunkdestination->routeref, '"routeref" should have defaulted to null');        
            }
     public function testGetArrayCopyReturnsCopyOfAllProperties()
     {
     	$trunkdestination = new TrunkDestination();     	
     	$data = array(
     					'trunkref'=> 197,
    					'numbermatchref'=> 21,
    					'routeref'=> 10      		 
            );
        $trunkdestination->exchangeArray($data);
        $this->assertEquals($data, $trunkdestination->getArrayCopy());
     	     	
     }
}
