<?php
namespace PbxAgiTest\ExtensionGroup\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\ExtensionGroup\Model\ExtensionGroup;
use PbxAgi\ExtensionGroup\Model\ExtensionGroupTable;

class ExtensionGroupTest extends PHPUnit_Framework_TestCase
{
    public function testExtensionGroupInitialState()
    {
        $extensiongroup = new ExtensionGroup();
         $this->assertNull($extensiongroup->id, '"id" should initially be null');
         $this->assertNull($extensiongroup->name, '"name" should initially be null');
         $this->assertNull($extensiongroup->transfer, '"transfer" should initially be null');
         $this->assertNull($extensiongroup->statuschange, '"statuschange" should initially be null');
         $this->assertNull($extensiongroup->incoming, '"incoming" should initially be null');
         $this->assertNull($extensiongroup->memberofcallcentreque, '"memberofcallcentreque" should initially be null');
         $this->assertNull($extensiongroup->hold, '"hold" should initially be null');
         $this->assertNull($extensiongroup->forwarding, '"forwarding" should initially be null');
         $this->assertNull($extensiongroup->custdesc, '"custdesc" should initially be null');
         $this->assertNull($extensiongroup->group_members_status, '"group_members_status" should initially be null');
         $this->assertNull($extensiongroup->number_status, '"number_status" should initially be null');          
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$extnsionsiongroup = new ExtensionGroup();
		$data = array(
 		         'id'=> 1,
 				 'name'=> 'тест',
				 'transfer'=> 'allowed',
				 'statuschange'=>'allowed',
				 'incoming' => 'forbidden',
				'memberofcallcentreque'=>true,
				'hold'=>'forbidden',
				'forwarding'=>'allowed',
				'custdesc'=>'',
				'group_members_status'=>'ACTIVE',
				'number_status'=>'UNDEFINED'				
		    );
         $extnsionsiongroup->exchangeArray($data);

         $this->assertSame($data['id'], $extnsionsiongroup->id, '"id" was not set correctly');
         $this->assertSame($data['name'], $extnsionsiongroup->name, '"name" was not set correctly');
         $this->assertSame($data['transfer'], $extnsionsiongroup->transfer, '"transfer" was not set correctly');
         $this->assertSame($data['statuschange'], $extnsionsiongroup->statuschange, '"statuschange" was not set correctly');
         $this->assertSame($data['incoming'], $extnsionsiongroup->incoming, '"incoming" was not set correctly');
         $this->assertSame($data['memberofcallcentreque'], $extnsionsiongroup->memberofcallcentreque, '"memberofcallcentreque" was not set correctly');
         $this->assertSame($data['hold'], $extnsionsiongroup->hold, '"hold" was not set correctly');
         $this->assertSame($data['forwarding'], $extnsionsiongroup->forwarding, '"forwarding" was not set correctly');
         $this->assertSame($data['custdesc'], $extnsionsiongroup->custdesc, '"custdesc" was not set correctly');
         $this->assertSame($data['group_members_status'], $extnsionsiongroup->group_members_status, '"group_members_status" was not set correctly');
         $this->assertSame($data['custdesc'], $extnsionsiongroup->custdesc, '"custdesc" was not set correctly');
         $this->assertSame($data['number_status'], $extnsionsiongroup->number_status, '"number_status" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$extnsionsiongroup = new ExtensionGroup();
    	
        $extnsionsiongroup->exchangeArray(array(
     		       'id'=> 1,
 				 'name'=> 'тест',
				 'transfer'=> 'allowed',
				 'statuschange'=>'allowed',
				 'incoming' => 'forbidden',
				'memberofcallcentreque'=>true,
				'hold'=>'forbidden',
				'forwarding'=>'allowed',
				'custdesc'=>'',
				'group_members_status'=>'ACTIVE',
				'number_status'=>'UNDEFINED'	  		 
            ));
        $extnsionsiongroup->exchangeArray(array());
    
        $this->assertNull($extnsionsiongroup->id, '"id" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->name, '"name" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->transfer, '"transfer" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->statuschange, '"statuschange" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->incoming, '"incoming" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->memberofcallcentreque, '"memberofcallcentreque" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->hold, '"hold" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->forwarding, '"forwarding" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->custdesc, '"custdesc" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->group_members_status, '"group_members_status" should have defaulted to null');
        $this->assertNull($extnsionsiongroup->number_status, '"number_status" should have defaulted to null');
         
             }
      public function testGetArrayCopyPerformsCorrectly()
      {
          $extensiongroup = new ExtensionGroup();
          $this->assertSame(get_object_vars($extensiongroup), $extensiongroup->getArrayCopy(), 'getArrayCopy should return array copy of ExtensionGroup porperties');
      }
}
