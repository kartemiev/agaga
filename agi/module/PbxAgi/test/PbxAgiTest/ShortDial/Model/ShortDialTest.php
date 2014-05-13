<?php
namespace PbxAgiTest\ShortDial\Model;

use PHPUnit_Framework_TestCase;
use PbxAgi\ShortDial\Model\ShortDial;

class ShortDialTest extends PHPUnit_Framework_TestCase
{
    public function testRouteInitialState()
    {
        $shortdial = new ShortDial();
        $this->assertNull($shortdial->id, '"id" should initially be null');
        $this->assertNull($shortdial->peerid, '"peerid" should initially be null');
        $this->assertNull($shortdial->number, '"number" should initially be null');
        $this->assertNull($shortdial->short, '"short" should initially be null');       
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $shortdial = new ShortDial();
        $data  = array(        		
        		'id'     => 1,
        		'peerid'=> 10,
        		'number'=>'84956408040',
        		'short'=>'12'            
        );

        $shortdial->exchangeArray($data);

         $this->assertSame($data['peerid'], $shortdial->peerid, '"peerid" was not set correctly');
         $this->assertSame($data['number'], $shortdial->number, '"number" was not set correctly');
         $this->assertSame($data['short'], $shortdial->short, '"short" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $shortdial = new ShortDial();
        
        $shortdial->exchangeArray(         	
            array(
            		'id'     => 1,
            		'peerid'=> 10,
            		'number'=>'84956408040',
            		'short'=>'12'
            )            
        );
        $shortdial->exchangeArray(array());
    
        $this->assertNull($shortdial->id, '"id" should have defaulted to null');
        $this->assertNull($shortdial->peerid, '"peerid" should have defaulted to null');
        $this->assertNull($shortdial->number, '"number" should have defaulted to null');
        $this->assertNull($shortdial->short, '"short" should have defaulted to null');        
            }
}
