<?php
namespace PbxAgiTest\RegEntry\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\RegEntry\Model\RegEntry;
 
class RegEntryTest extends PHPUnit_Framework_TestCase
{    
    public $numbermatchref;
    public $regexpression;
    
    public function testRegEntryInitialState()
    {        
         $regentry = new RegEntry();
         $this->assertNull($regentry->numbermatchref, '"numbermatchref" should initially be null');
         $this->assertNull($regentry->regexpression, '"regexpression" should initially be null');
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $regentry = new RegEntry();
                        
        $data = array(		          
		         'numbermatchref'=> 1,
		         'regexpression'=> '/^7/'		    
		    );
         $regentry->exchangeArray($data);

         $this->assertSame($data['numbermatchref'], $regentry->numbermatchref, '"numbermatchref" was not set correctly');
         $this->assertSame($data['regexpression'], $regentry->regexpression, '"regexpression" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $regentry = new RegEntry();
                 
        $regentry->exchangeArray(array(		          
		          'numbermatchref'=> 1,
		         'regexpression'=> '/^7/'		    
		    ));
        
        $regentry->exchangeArray(array());
    
        $this->assertNull($regentry->numbermatchref, '"numbermatchref" should have defaulted to null');
        $this->assertNull($regentry->regexpression, '"regexpression" should have defaulted to null');         
      
    }
    
    public function testGetArrayCopyPerformsCorrectly()
    {
    	$regentry = new RegEntry();
    	$this->assertSame(get_object_vars($regentry), $regentry->getArrayCopy(), 'RegEntry should return array copy of RegEntry porperties');
    }
}
