<?php
namespace PbxAgiTest\TrunkTest\Model;

use PHPUnit_Framework_TestCase;
use PbxAgi\Trunk\Model\Trunk;
 
class TrunkTest extends PHPUnit_Framework_TestCase
{
     
    public function testTrunkInitialState()
    {
        $trunk = new Trunk();
        $this->assertNull($trunk->id, '"id" should initially be null');
        $this->assertNull($trunk->secret, '"secret" should initially be null');
        $this->assertNull($trunk->custname, '"custname" should initially be null');
        $this->assertNull($trunk->custdesc, '"custdesc" should initially be null');       
        $this->assertNull($trunk->name, '"name" should initially be null');        
        $this->assertNull($trunk->defaultuser, '"defaultuser" should initially be null');
        $this->assertNull($trunk->callbackextension, '"callbackextension" should initially be null');
        $this->assertNull($trunk->callerid, '"callerid" should initially be null');
        
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $trunk = new Trunk();
        $data  = array(        		
        		'id'     => 1,
        		'secret'=> '12345',
         		'custname'=>'Иван Иванов',      
        		'custdesc'=>'',
                'name'=>'000011',
                'defaultuser'=>'000011',
                'callbackextension'=>'000011',
                'callerid'=>'74956408040'            
        );

        $trunk->exchangeArray($data);

         $this->assertSame($data['id'], $trunk->id, '"id" was not set correctly');
         $this->assertSame($data['secret'], $trunk->secret, '"secret" was not set correctly');
         $this->assertSame($data['custname'], $trunk->custname, '"custname" was not set correctly');
         $this->assertSame($data['custdesc'], $trunk->custdesc, '"custdesc" was not set correctly');
         $this->assertSame($data['name'], $trunk->name, '"name" was not set correctly');
         $this->assertSame($data['defaultuser'], $trunk->defaultuser, '"defaultuser" was not set correctly');
         $this->assertSame($data['callbackextension'], $trunk->callbackextension, '"callbackextension" was not set correctly');
         $this->assertSame($data['callerid'], $trunk->callerid, '"callerid" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $trunk = new Trunk();
                        
        $trunk->exchangeArray(         	
            array(        		
        		'id'     => 1,
        		'secret'=> '12345',
         		'custname'=>'Иван Иванов',      
        		'custdesc'=>'',
                'name'=>'000011',
                'defaultuser'=>'000011',
                'callbackextension'=>'000011',
                'callerid'=>'74956408040'            
            )

        );
        $trunk->exchangeArray(array());
    
        $this->assertNull($trunk->id, '"id" should have defaulted to null');
        $this->assertNull($trunk->secret, '"secret" should have defaulted to null');
        $this->assertNull($trunk->custname, '"custname" should have defaulted to null');
        $this->assertNull($trunk->custdesc, '"custdesc" should have defaulted to null');
        $this->assertNull($trunk->name, '"name" should have defaulted to null');
        $this->assertNull($trunk->defaultuser, '"defaultuser" should have defaulted to null');
        $this->assertNull($trunk->callbackextension, '"callbackextension" should have defaulted to null');
        $this->assertNull($trunk->callerid, '"callerid" should have defaulted to null');        
      }
}
