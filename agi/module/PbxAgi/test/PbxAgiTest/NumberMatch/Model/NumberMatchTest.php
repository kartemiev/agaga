<?php
namespace PbxAgiTest\NumberMatch\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\NumberMatch\Model\NumberMatch;

class NumberMatchTest extends PHPUnit_Framework_TestCase
{    
 
    public function testNumberMatchInitialState()
    {        
         $numbermatch = new NumberMatch();
         $this->assertNull($numbermatch->id, '"id" should initially be null');
         $this->assertNull($numbermatch->custname, '"custname" should initially be null');
         $this->assertNull($numbermatch->regentries, '"regentries" should initially be null');
         $this->assertNull($numbermatch->custdesc, '"custdesc" should initially be null');          
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $numbermatch = new NumberMatch();
        
        $data = array(		          
		         'custname'=> 'Только москва',
		         'regentries'=> 1,		    
                 'custdesc'=> ''		                
		    );
         $numbermatch->exchangeArray($data);

         $this->assertSame($data['custname'], $numbermatch->custname, '"custname" was not set correctly');
         $this->assertSame($data['regentries'], $numbermatch->regentries, '"regentries" was not set correctly');          
         $this->assertSame($data['custdesc'], $numbermatch->custdesc, '"custdesc" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $numbermatch = new NumberMatch();
                    	
        $numbermatch->exchangeArray(array(		          
		         'custname'=> 'Только москва',
		         'regentries'=> 1,		    
                 'custdesc'=> ''		                
		    ));
        $numbermatch->exchangeArray(array());
    
        $this->assertNull($numbermatch->id, '"id" should have defaulted to null');
        $this->assertNull($numbermatch->custname, '"custname" should have defaulted to null');
        $this->assertNull($numbermatch->regentries, '"regentries" should have defaulted to null');         
        $this->assertNull($numbermatch->custdesc, '"custdesc" should have defaulted to null');        
    }
}
