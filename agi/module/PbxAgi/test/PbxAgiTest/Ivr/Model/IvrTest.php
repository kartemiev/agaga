<?php
namespace PbxAgiTest\FaxUser\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\Ivr\Model\Ivr;

class IvrTest extends PHPUnit_Framework_TestCase
{
    public function testIvrInitialState()
    {        
         $ivr = new Ivr();
         $this->assertNull($ivr->id, '"id" should initially be null');
         $this->assertNull($ivr->custname, '"custname" should initially be null');
         $this->assertNull($ivr->custdesc, '"custdesc" should initially be null');
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$ivr = new Ivr();
		$data = array(		          
		         'custname'=> 'основное приветствие предприятия',
		         'custdesc'=> ''		    
		    );
         $ivr->exchangeArray($data);

         $this->assertSame($data['custname'], $ivr->custname, '"custname" was not set correctly');
         $this->assertSame($data['custdesc'], $ivr->custdesc, '"custdesc" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$ivr = new Ivr();
            	
        $ivr->exchangeArray(array(
		         'custname'=> 'основное приветствие предприятия',
		         'custdesc'=> ''	
                                            ));
        $ivr->exchangeArray(array());
    
        $this->assertNull($ivr->id, '"id" should have defaulted to null');
        $this->assertNull($ivr->custname, '"custname" should have defaulted to null');
        $this->assertNull($ivr->custdesc, '"custdesc" should have defaulted to null');
         
     }
}
