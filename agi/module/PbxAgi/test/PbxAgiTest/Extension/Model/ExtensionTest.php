<?php
namespace PbxAgiTest\Extension\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\Extension\Model\Extension;
use Zend\Filter\Word\UnderscoreToCamelCase;


class ExtensionTest extends PHPUnit_Framework_TestCase
{
     
    public function testExtensionInitialState()
    {
        $extension = new Extension();
         $this->assertNull($extension->id, '"id" should initially be null');
         $this->assertNull($extension->extension, '"extension" should initially be null');
         $this->assertNull($extension->extensiongroup, '"extensiongroup" should initially be null');
         $this->assertNull($extension->extensiontype, '"extensiontype" should initially be null');
         $this->assertNull($extension->name, '"name" should initially be null');
         $this->assertNull($extension->outgoingcallspermission, '"outgoingcallspermission" should initially be null');
         $this->assertNull($extension->transfer, '"transfer" should initially be null');
         $this->assertNull($extension->statuschange, '"statuschange" should initially be null');
         $this->assertNull($extension->incoming, '"incoming" should initially be null');
         $this->assertNull($extension->hold, '"hold" should initially be null');
         $this->assertNull($extension->forwarding, '"forwarding" should initially be null');
         $this->assertNull($extension->memberofcallcentreque, '"memberofcallcentreque" should initially be null');
         $this->assertNull($extension->mailbox, '"mailbox" should initially be null');
         $this->assertNull($extension->callsequence, '"callsequence" should initially be null');
         $this->assertNull($extension->number_status, '"number_status" should initially be null');
         $this->assertNull($extension->extensionrecord, '"extensionrecord" should initially be null');
         $this->assertNull($extension->peertype, '"peertype" should initially be null');
         $this->assertNull($extension->diversion_unconditional_status, '"diversion_unconditional_status" should initially be null');
         $this->assertNull($extension->diversion_unconditional_number, '"diversion_unconditional_number" should initially be null');
         $this->assertNull($extension->diversion_unavail_status, '"diversion_unavail_status" should initially be null');
         $this->assertNull($extension->diversion_busy_status, '"diversion_busy_status" should initially be null');
         $this->assertNull($extension->diversion_busy_number, '"diversion_busy_number" should initially be null');
         $this->assertNull($extension->diversion_noanswer_status, '"diversion_noanswer_status" should initially be null');
         $this->assertNull($extension->diversion_noanswer_number, '"diversion_noanswer_number" should initially be null');
         $this->assertNull($extension->diversion_unconditional_landingtype, '"diversion_unconditional_landingtype" should initially be null');
         $this->assertNull($extension->diversion_busy_landingtype, '"diversion_busy_landingtype" should initially be null');
         $this->assertNull($extension->diversion_noanswer_landingtype, '"diversion_noanswer_landingtype" should initially be null');          
         $this->assertNull($extension->diversion_unavail_landingtype, '"diversion_unavail_landingtype" should initially be null');
         $this->assertNull($extension->diversion_noanswer_duration, '"diversion_noanswer_duration" should initially be null');          
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$extension = new Extension();
		$data = array(
		      'id'=>2,
		      'extension'=>'100',
		      'extensiongroup'=>3,
		      'extensiontype'=>'',
		      'name'=>'100',
		      'outgoingcallspermission'=>'undefined',
		      'transfer'=>'allowed',
		      'statuschange'=>'allowed',
		      'incoming'=>'allowed',
		      'hold'=>'allowed',
		      'forwarding'=>'allowed',
		      'memberofcallcentreque'=>true,
		      'mailbox'=>'100@default',
		      'callsequence'=>'sequential',
		      'number_status'=>'active',
		      'extensionrecord'=>'UNDEFINED',
		      'peertype'=>'EXTENSION',
		      'diversion_unconditional_status'=>'UNDEFINED',
		      'diversion_unconditional_number'=>'',
		      'diversion_unavail_status'=>'UNDEFINED',
		      'diversion_unavail_number'=>'',
		      'diversion_busy_status'=>'UNDEFINED',
		      'diversion_busy_number'=>'',
		      'diversion_noanswer_status'=>'UNDEFINED',
		      'diversion_noanswer_number'=>'',
		      'diversion_unconditional_landingtype'=>'',
		      'diversion_busy_landingtype'=>'',
		      'diversion_noanswer_landingtype'=>'',
		      'diversion_unavail_landingtype'=>'',
		      'diversion_noanswer_duration'=>''
		    
		);
         $extension->exchangeArray($data);

         $this->assertSame($data['id'], $extension->id, '"id" was not set correctly');
         $this->assertSame($data['extension'], $extension->extension, '"extension" was not set correctly');
         $this->assertSame($data['extensiongroup'], $extension->extensiongroup, '"extensiongroup" was not set correctly');
         $this->assertSame($data['extensiontype'], $extension->extensiontype, '"extensiontype" was not set correctly');
         $this->assertSame($data['name'], $extension->name, '"name" was not set correctly');
         $this->assertSame($data['outgoingcallspermission'], $extension->outgoingcallspermission, '"outgoingcallspermission" was not set correctly');
         $this->assertSame($data['transfer'], $extension->transfer, '"transfer" was not set correctly');
         $this->assertSame($data['statuschange'], $extension->statuschange, '"statuschange" was not set correctly');
         $this->assertSame($data['incoming'], $extension->incoming, '"incoming" was not set correctly');
         $this->assertSame($data['hold'], $extension->hold, '"hold" was not set correctly');
         $this->assertSame($data['forwarding'], $extension->forwarding, '"forwarding" was not set correctly');
         $this->assertSame($data['memberofcallcentreque'], $extension->memberofcallcentreque, '"memberofcallcentreque" was not set correctly');
         $this->assertSame($data['mailbox'], $extension->mailbox, '"mailbox" was not set correctly');
         $this->assertSame($data['callsequence'], $extension->callsequence, '"callsequence" was not set correctly');
         $this->assertSame($data['number_status'], $extension->number_status, '"number_status" was not set correctly');
         $this->assertSame($data['extensionrecord'], $extension->extensionrecord, '"extensionrecord" was not set correctly');
         $this->assertSame($data['peertype'], $extension->peertype, '"peertype" was not set correctly');
         $this->assertSame($data['diversion_unconditional_status'], $extension->diversion_unconditional_status, '"diversion_unconditional_status" was not set correctly');
         $this->assertSame($data['diversion_unconditional_number'], $extension->diversion_unconditional_number, '"diversion_unconditional_number" was not set correctly');
         $this->assertSame($data['diversion_unavail_status'], $extension->diversion_unavail_status, '"diversion_unavail_status" was not set correctly');
         $this->assertSame($data['diversion_unavail_number'], $extension->diversion_unavail_number, '"diversion_unavail_number" was not set correctly');
         $this->assertSame($data['diversion_busy_status'], $extension->diversion_busy_status, '"diversion_busy_status" was not set correctly');
         $this->assertSame($data['diversion_busy_number'], $extension->diversion_busy_number, '"diversion_busy_number" was not set correctly');
         $this->assertSame($data['diversion_noanswer_status'], $extension->diversion_noanswer_status, '"diversion_noanswer_status" was not set correctly');
         $this->assertSame($data['diversion_noanswer_number'], $extension->diversion_noanswer_number, '"diversion_noanswer_number" was not set correctly');
         $this->assertSame($data['diversion_unconditional_landingtype'], $extension->diversion_unconditional_landingtype, '"diversion_unconditional_landingtype" was not set correctly');
         $this->assertSame($data['diversion_busy_landingtype'], $extension->diversion_busy_landingtype, '"diversion_busy_landingtype" was not set correctly');
         $this->assertSame($data['diversion_noanswer_landingtype'], $extension->diversion_noanswer_landingtype, '"diversion_noanswer_landingtype" was not set correctly');
         $this->assertSame($data['diversion_unavail_landingtype'], $extension->diversion_unavail_landingtype, '"diversion_unavail_landingtype" was not set correctly');
         $this->assertSame($data['diversion_noanswer_duration'], $extension->diversion_noanswer_duration, '"diversion_noanswer_duration" was not set correctly');
          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$extension = new Extension();
    	
        $extension->exchangeArray(array(
		      'id'=>2,
		      'extension'=>'100',
		      'extensiongroup'=>3,
		      'extensiontype'=>'',
		      'name'=>'100',
		      'outgoingcallspermission'=>'undefined',
		      'transfer'=>'allowed',
		      'statuschange'=>'allowed',
		      'incoming'=>'allowed',
		      'hold'=>'allowed',
		      'forwarding'=>'allowed',
		      'memberofcallcentreque'=>true,
		      'mailbox'=>'100@default',
		      'callsequence'=>'sequential',
		      'number_status'=>'active',
		      'extensionrecord'=>'UNDEFINED',
		      'peertype'=>'EXTENSION',
		      'diversion_unconditional_status'=>'UNDEFINED',
		      'diversion_unconditional_number'=>'',
		      'diversion_unavail_status'=>'UNDEFINED',
		      'diversion_unavail_number'=>'',
		      'diversion_busy_status'=>'UNDEFINED',
		      'diversion_busy_number'=>'',
		      'diversion_noanswer_status'=>'UNDEFINED',
		      'diversion_noanswer_number'=>'',
		      'diversion_unconditional_landingtype'=>'',
		      'diversion_busy_landingtype'=>'',
		      'diversion_noanswer_landingtype'=>'',
		      'diversion_unavail_landingtype'=>'',
		      'diversion_noanswer_duration'=>''
		    
		));
        $extension->exchangeArray(array());
    
        $this->assertNull($extension->id, '"id" should have defaulted to null');        
        $this->assertNull($extension->extension, '"extension" should have defaulted to null');
        $this->assertNull($extension->extensiongroup, '"extensiongroup" should have defaulted to null');
        $this->assertNull($extension->extensiontype, '"extensiontype" should have defaulted to null');
        $this->assertNull($extension->name, '"name" should have defaulted to null');
        $this->assertNull($extension->outgoingcallspermission, '"outgoingcallspermission" should have defaulted to null');
        $this->assertNull($extension->transfer, '"transfer" should have defaulted to null');
        $this->assertNull($extension->statuschange, '"statuschange" should have defaulted to null');
        $this->assertNull($extension->incoming, '"incoming" should have defaulted to null');
        $this->assertNull($extension->hold, '"hold" should have defaulted to null');
        $this->assertNull($extension->forwarding, '"forwarding" should have defaulted to null');
        $this->assertNull($extension->memberofcallcentreque, '"memberofcallcentreque" should have defaulted to null');
        $this->assertNull($extension->mailbox, '"mailbox" should have defaulted to null');
        $this->assertNull($extension->callsequence, '"callsequence" should have defaulted to null');
        $this->assertNull($extension->number_status, '"number_status" should have defaulted to null');
        $this->assertNull($extension->extensionrecord, '"extensionrecord" should have defaulted to null');
        $this->assertNull($extension->peertype, '"peertype" should have defaulted to null');
        $this->assertNull($extension->diversion_unconditional_status, '"diversion_unconditional_status" should have defaulted to null');
        $this->assertNull($extension->diversion_unconditional_number, '"diversion_unconditional_number" should have defaulted to null');
        $this->assertNull($extension->diversion_unavail_status, '"diversion_unavail_status" should have defaulted to null');
        $this->assertNull($extension->diversion_unavail_number, '"diversion_unavail_number" should have defaulted to null');
        $this->assertNull($extension->diversion_busy_status, '"diversion_busy_status" should have defaulted to null');
        $this->assertNull($extension->diversion_busy_number, '"diversion_busy_number" should have defaulted to null');
        $this->assertNull($extension->diversion_noanswer_status, '"diversion_noanswer_status" should have defaulted to null');
        $this->assertNull($extension->diversion_noanswer_number, '"diversion_noanswer_number" should have defaulted to null');
        $this->assertNull($extension->diversion_unconditional_landingtype, '"diversion_unconditional_landingtype" should have defaulted to null');
        $this->assertNull($extension->diversion_busy_landingtype, '"diversion_busy_landingtype" should have defaulted to null');
        $this->assertNull($extension->diversion_noanswer_landingtype, '"diversion_noanswer_landingtype" should have defaulted to null');
        $this->assertNull($extension->diversion_unavail_landingtype, '"diversion_unavail_landingtype" should have defaulted to null');
        $this->assertNull($extension->diversion_noanswer_duration, '"diversion_noanswer_duration" should have defaulted to null');
        
             }
     public function testSettersAndGettersPerformCorrectly()
             {
             	$extension = new Extension();
             	$filter = new UnderscoreToCamelCase();
             
             	foreach ($extension as $propertyname=>$propertyvalue)
             	{
             		$methodNameMutator = 'set'. $filter($propertyname);
             		$methodNameAccessor = 'get'. $filter($propertyname);
             			
             		if (!method_exists($extension, $methodNameMutator))
             		{
             			throw new \Exception('method '.$methodNameMutator.' doesnt exist');
             		}
             		if (!method_exists($extension, $methodNameAccessor))
             		{
             			throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
             		}
             		call_user_func(array($extension,$methodNameMutator),'test');
             		$result = call_user_func(array($extension,$methodNameAccessor));
             		$this->assertSame($result, 'test');
             	}
     }
}
