<?php
namespace PbxAgiTest\SkypeAlias\Model;

use PHPUnit_Framework_TestCase;
use PbxAgi\SkypeAlias\Model\SkypeAlias;

class SkypeAliasTest extends PHPUnit_Framework_TestCase
{

    public function testSkypeAliasInitialState()
    {
        $skypealias = new SkypeAlias();
        $this->assertNull($skypealias->id, '"id" should initially be null');
        $this->assertNull($skypealias->number, '"number" should initially be null');
        $this->assertNull($skypealias->skypeid, '"number" should initially be null');
        $this->assertNull($skypealias->custname, '"custname" should initially be null');       
        $this->assertNull($skypealias->custdesc, '"custdesc" should initially be null');        
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $skypealias = new SkypeAlias();
        $data  = array(        		
        		'id'     => 1,
        		'number'=> '12',
        		'skypeid'=>'ivan_ivanov',
        		'custname'=>'Иван Иванов',      
        		'custdesc'=>''                        
        );

        $skypealias->exchangeArray($data);

         $this->assertSame($data['id'], $skypealias->id, '"id" was not set correctly');
         $this->assertSame($data['number'], $skypealias->number, '"number" was not set correctly');
         $this->assertSame($data['skypeid'], $skypealias->skypeid, '"skypeid" was not set correctly');          
         $this->assertSame($data['custname'], $skypealias->custname, '"custname" was not set correctly');
         $this->assertSame($data['custdesc'], $skypealias->custdesc, '"custdesc" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $skypealias = new SkypeAlias();
                
        $skypealias->exchangeArray(         	
                array(        		
        		'id'     => 1,
        		'number'=> '12',
        		'skypeid'=>'ivan_ivanov',
        		'custname'=>'Иван Иванов',      
        		'custdesc'=>''                        
                )        
        );
        $skypealias->exchangeArray(array());
    
        $this->assertNull($skypealias->id, '"id" should have defaulted to null');
        $this->assertNull($skypealias->number, '"number" should have defaulted to null');
        $this->assertNull($skypealias->skypeid, '"skypeid" should have defaulted to null');
        $this->assertNull($skypealias->custname, '"custname" should have defaulted to null');
        $this->assertNull($skypealias->custdesc, '"custdesc" should have defaulted to null');
        
      }
      
      public function testGetArrayCopyPerformsCorrectly()
      {
      	$skypealias = new SkypeAlias();
      	$this->assertSame(get_object_vars($skypealias), $skypealias->getArrayCopy(), 'getArrayCopy should return array copy of SkypeAlias porperties');
      }
}
