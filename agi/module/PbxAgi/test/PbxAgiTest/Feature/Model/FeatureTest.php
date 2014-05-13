<?php
namespace PbxAgiTest\Feature\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\Feature\Model\Feature;

class FeatureTest extends PHPUnit_Framework_TestCase
{
    public function testFeatureInitialState()
    {
        
         $feature = new Feature();
         $this->assertNull($feature->id, '"id" should initially be null');
         $this->assertNull($feature->custname, '"custname" should initially be null');
         $this->assertNull($feature->custdesc, '"custdesc" should initially be null');
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$feature = new Feature();
		$data = array(
		         'id'=>1,
		         'custname'=> 'телеконференция',
		         'custdesc'=> ''		    
		    );
         $feature->exchangeArray($data);

         $this->assertSame($data['custname'], $feature->custname, '"custname" was not set correctly');
         $this->assertSame($data['custdesc'], $feature->custdesc, '"custdesc" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$feature = new Feature();
    	
        $feature->exchangeArray(array(
                 'id' => 1,            
		         'custname'=> 'телеконференция',
		         'custdesc'=> ''		    
                                    ));
        $feature->exchangeArray(array());    
        $this->assertNull($feature->id, '"id" should have defaulted to null');
        $this->assertNull($feature->custname, '"custname" should have defaulted to null');
        $this->assertNull($feature->custdesc, '"custdesc" should have defaulted to null');         
     }
     public function testGetArrayCopyPerformsCorrectly()
     {
     	$feature = new Feature();
     	$this->assertSame(get_object_vars($feature), $feature->getArrayCopy(), 'getArrayCopy should return array copy of Feature porperties');
     }
}
