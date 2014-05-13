<?php
namespace PbxAgiTest\TrunkAssocTest\Model;

use PHPUnit_Framework_TestCase;
use PbxAgi\TrunkAssoc\Model\TrunkAssoc;
 
class TrunkAssocTest extends PHPUnit_Framework_TestCase
{
    
    public function testTrunkInitialState()
    {
        $trunkAssoc = new TrunkAssoc();
        $this->assertNull($trunkAssoc->id, '"id" should initially be null');
        $this->assertNull($trunkAssoc->trunkref, '"trunkref" should initially be null');
        $this->assertNull($trunkAssoc->contextref, '"contextref" should initially be null');        
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $trunkAssoc = new TrunkAssoc();
        $data  = array(        		
        		'id' => 1,
                'trunkref' => 2,
                'contextref' => 3            
        );
        $trunkAssoc->exchangeArray($data);
         $this->assertSame($data['id'], $trunkAssoc->id, '"id" was not set correctly');
         $this->assertSame($data['trunkref'], $trunkAssoc->trunkref, '"trunkref" was not set correctly');
         $this->assertSame($data['contextref'], $trunkAssoc->contextref, '"contextref" was not set correctly');         
     }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $trunkAssoc = new TrunkAssoc();                                
        $trunkAssoc->exchangeArray(         	
        array(        		
        		'id' => 1,
                'trunkref' => 2,
                'contextref' => 3            
        )
        );
        $trunkAssoc->exchangeArray(array());
        $this->assertNull($trunkAssoc->id, '"id" should have defaulted to null');
        $this->assertNull($trunkAssoc->trunkref, '"id" should have defaulted to null');
        $this->assertNull($trunkAssoc->contextref, '"id" should have defaulted to null');        
    }
    public function testGetArrayCopyReturnsCopyOfAllProperties()
    {
    	$trunkassoc = new TrunkAssoc();
    	$data = array(
    			'id' => 1,
                'trunkref' => 2,
                'contextref' => 3   
    	);
    	$trunkassoc->exchangeArray($data);
    	$this->assertEquals($data, $trunkassoc->getArrayCopy());
    
    }
}
