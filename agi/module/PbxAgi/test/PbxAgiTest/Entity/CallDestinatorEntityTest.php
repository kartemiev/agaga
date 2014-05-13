<?php
namespace PbxAgiTest\Entity;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\Entity\CallDestinatorEntity;
 

class CallDestinatorEntityTest extends PHPUnit_Framework_TestCase
{
    public function testCallDestinatorInitialState()
    {
    	$calldestinatorentity = new CallDestinatorEntity();

    	$this->assertNull($calldestinatorentity->id, '"id" should initially be null');
    	$this->assertNull($calldestinatorentity->name, '"name" should initially be null');
    	$this->assertNull($calldestinatorentity->extension, '"extension" should initially be null');
    	$this->assertNull($calldestinatorentity->extensiongroup, '"extensiongroup" should initially be null');
    	$this->assertNull($calldestinatorentity->extensiontype, '"extensiontype" should initially be null');
    	$this->assertNull($calldestinatorentity->operatorstatus, '"operatorstatus" should initially be null');
    	$this->assertNull($calldestinatorentity->outgoingcallspermission, '"outgoingcallspermission" should initially be null');
    	$this->assertNull($calldestinatorentity->transfer, '"transfer" should initially be null');
    	$this->assertNull($calldestinatorentity->statuschange, '"statuschange" should initially be null');
    	$this->assertNull($calldestinatorentity->incoming, '"incoming" should initially be null');
    	$this->assertNull($calldestinatorentity->hold, '"hold" should initially be null');
    	$this->assertNull($calldestinatorentity->forwarding, '"forwarding" should initially be null');
    	$this->assertNull($calldestinatorentity->memberofcallcentreque, '"memberofcallcentreque" should initially be null');
    	$this->assertNull($calldestinatorentity->mailbox, '"mailbox" should initially be null');
    	$this->assertNull($calldestinatorentity->peertype, '"peertype" should initially be null');
    	$this->assertNull($calldestinatorentity->routeref, '"routeref" should initially be null');
    	$this->assertNull($calldestinatorentity->number_status, '"number_status" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_unconditional_status, '"diversion_unconditional_status" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_unconditional_number, '"diversion_unconditional_number" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_unavail_status, '"diversion_unavail_status" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_unavail_number, '"diversion_unavail_number" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_busy_status, '"diversion_busy_status" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_busy_number, '"diversion_busy_number" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_noanswer_status, '"diversion_noanswer_status" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_noanswer_number, '"diversion_noanswer_number" should initially be null');
    	$this->assertNull($calldestinatorentity->diversion_unavail_duration, '"diversion_unavail_duration" should initially be null');    	 
    }
    
    public function testExchangeArraySetsPropertiesCorrectly()
    {
    	$calldestinatorentity = new CallDestinatorEntity();
    	$data  = array(
    	               'id' => 1,
    			       'name'     => 'testname',
    			       'extension'  => '101',
    	               'extensiongroup'=>12,
    	               'extensiontype'=>'regular',
    	               'operatorstatus'=>'online',
    	               'outgoingcallspermission'=>'allowed',
    	               'transfer'=>'allowed',
    	               'statuschange'=>'allowed',
    	               'incoming'=> 'allowed',
    	               'hold'=> 'allowed',
    	               'forwarding'=> 'allowed',
    	               'memberofcallcentreque' => 'allowed',
    	               'mailbox' => '101',
    	               'peertype'=> 'EXTENSION',
    	               'routeref'=>1,
    	               'number_status'=>'enabled',
    	               'diversion_unconditional_status'=>'UNDEFINED',
    	               'diversion_unconditional_number'=>'',
    	               'diversion_unavail_status'=>'UNDEFINED',
    	               'diversion_unavail_number'=>'',
    	               'diversion_busy_status'=>'UNDEFINED',
    	               'diversion_busy_number'=>'',
    	               'diversion_noanswer_status'=>'UNDEFINED',
    	               'diversion_noanswer_number'=>'',
    	               'diversion_unavail_duration'=>20
    	        	           );
    
    	$calldestinatorentity->exchangeArray($data);
    
    	$this->assertSame($data['id'], $calldestinatorentity->id, '"id" was not set correctly');
    	$this->assertSame($data['name'], $calldestinatorentity->name, '"name" was not set correctly');
    	$this->assertSame($data['extension'], $calldestinatorentity->extension, '"extension" was not set correctly');    	
    	$this->assertSame($data['extensiongroup'], $calldestinatorentity->extensiongroup, '"extensiongroup" was not set correctly');
    	$this->assertSame($data['extensiontype'], $calldestinatorentity->extensiontype, '"extensiontype" was not set correctly');
    	$this->assertSame($data['operatorstatus'], $calldestinatorentity->operatorstatus, '"operatorstatus" was not set correctly');
    	$this->assertSame($data['outgoingcallspermission'], $calldestinatorentity->outgoingcallspermission, '"outgoingcallspermission" was not set correctly');
    	$this->assertSame($data['transfer'], $calldestinatorentity->transfer, '"transfer" was not set correctly');
    	$this->assertSame($data['statuschange'], $calldestinatorentity->statuschange, '"statuschange" was not set correctly');
    	$this->assertSame($data['incoming'], $calldestinatorentity->incoming, '"incoming" was not set correctly');
    	$this->assertSame($data['hold'], $calldestinatorentity->hold, '"hold" was not set correctly');
    	$this->assertSame($data['forwarding'], $calldestinatorentity->forwarding, '"forwarding" was not set correctly');
    	$this->assertSame($data['memberofcallcentreque'], $calldestinatorentity->memberofcallcentreque, '"memberofcallcentreque" was not set correctly');
    	$this->assertSame($data['mailbox'], $calldestinatorentity->mailbox, '"mailbox" was not set correctly');
    	$this->assertSame($data['peertype'], $calldestinatorentity->peertype, '"peertype" was not set correctly');
    	$this->assertSame($data['routeref'], $calldestinatorentity->routeref, '"routeref" was not set correctly');
    	$this->assertSame($data['number_status'], $calldestinatorentity->number_status, '"number_status" was not set correctly');
    	$this->assertSame($data['diversion_unconditional_status'], $calldestinatorentity->diversion_unconditional_status, '"diversion_unconditional_status" was not set correctly');
    	$this->assertSame($data['diversion_unconditional_number'], $calldestinatorentity->diversion_unconditional_number, '"forwarding" was not set correctly');
    	$this->assertSame($data['diversion_unavail_status'], $calldestinatorentity->diversion_unavail_status, '"diversion_unavail_status" was not set correctly');
    	$this->assertSame($data['diversion_unavail_number'], $calldestinatorentity->diversion_unavail_number, '"diversion_unavail_number" was not set correctly');
    	$this->assertSame($data['diversion_busy_status'], $calldestinatorentity->diversion_busy_status, '"diversion_busy_status" was not set correctly');    	
    	$this->assertSame($data['diversion_busy_number'], $calldestinatorentity->diversion_busy_number, '"diversion_busy_number" was not set correctly');    	 
    	$this->assertSame($data['diversion_noanswer_status'], $calldestinatorentity->diversion_noanswer_status, '"diversion_noanswer_status" was not set correctly');
    	$this->assertSame($data['diversion_noanswer_number'], $calldestinatorentity->diversion_noanswer_number, '"diversion_noanswer_number" was not set correctly');
    	$this->assertSame($data['diversion_unavail_duration'], $calldestinatorentity->diversion_unavail_duration, '"diversion_unavail_duration" was not set correctly');
    	 
    }
    
    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
    	$calldestinator = new CallDestinatorEntity();
    
    	$calldestinator->exchangeArray(
    	           array(
    	               'id' => 1,
    			       'name'     => 'testname',
    			       'extension'  => '101',
    	               'extensiongroup'=>12,
    	               'extensiontype'=>'regular',
    	               'operatorstatus'=>'online',
    	               'outgoingcallspermission'=>'allowed',
    	               'transfer'=>'allowed',
    	               'statuschange'=>'allowed',
    	               'incoming'=> 'allowed',
    	               'hold'=> 'allowed',
    	               'forwarding'=> 'allowed',
    	               'memberofcallcentreque' => 'allowed',
    	               'mailbox' => '101',
    	               'peertype'=> 'EXTENSION',
    	               'routeref'=>1,
    	               'number_status'=>'enabled',
    	               'diversion_unconditional_status'=>'UNDEFINED',
    	               'diversion_unconditional_number'=>'',
    	               'diversion_unavail_status'=>'UNDEFINED',
    	               'diversion_unavail_number'=>'',
    	               'diversion_busy_status'=>'UNDEFINED',
    	               'diversion_busy_number'=>'',
    	               'diversion_noanswer_status'=>'UNDEFINED',
    	               'diversion_noanswer_number'=>'',
    	               'diversion_unavail_duration'=>20    	                   	
    	           )
    	           );
    	$calldestinator->exchangeArray(array());
    
    	$this->assertNull($calldestinator->id, '"id" should have defaulted to null');
    	$this->assertNull($calldestinator->name, '"name" should have defaulted to null');
    	$this->assertNull($calldestinator->extension, '"extension" should have defaulted to null');
    	$this->assertNull($calldestinator->extensiongroup, '"extensiongroup" should have defaulted to null');
    	$this->assertNull($calldestinator->extensiontype, '"extensiontype" should have defaulted to null');
    	$this->assertNull($calldestinator->operatorstatus, '"operatorstatus" should have defaulted to null');
    	$this->assertNull($calldestinator->outgoingcallspermission, '"outgoingcallspermission" should have defaulted to null');
    	$this->assertNull($calldestinator->transfer, '"transfer" should have defaulted to null');
    	$this->assertNull($calldestinator->statuschange, '"statuschange" should have defaulted to null');
    	$this->assertNull($calldestinator->incoming, '"incoming" should have defaulted to null');
    	$this->assertNull($calldestinator->hold, '"hold" should have defaulted to null');
    	$this->assertNull($calldestinator->forwarding, '"forwarding" should have defaulted to null');
    	$this->assertNull($calldestinator->memberofcallcentreque, '"memberofcallcentreque" should have defaulted to null');
    	$this->assertNull($calldestinator->mailbox, '"mailbox" should have defaulted to null');
    	$this->assertNull($calldestinator->peertype, '"peertype" should have defaulted to null');
    	$this->assertNull($calldestinator->routeref, '"routeref" should have defaulted to null');
    	$this->assertNull($calldestinator->number_status, '"number_status" should have defaulted to null');
    	$this->assertNull($calldestinator->diversion_unconditional_status, '"diversion_unconditional_status" should have defaulted to null');    	
    	$this->assertNull($calldestinator->diversion_unconditional_number, '"diversion_unconditional_number" should have defaulted to null');
    	$this->assertNull($calldestinator->diversion_unavail_status, '"diversion_unavail_status" should have defaulted to null');
    	$this->assertNull($calldestinator->diversion_unavail_number, '"diversion_unavail_number" should have defaulted to null');
    	$this->assertNull($calldestinator->diversion_busy_status, '"diversion_busy_status" should have defaulted to null');
    	$this->assertNull($calldestinator->diversion_busy_number, '"diversion_busy_number" should have defaulted to null');
    	$this->assertNull($calldestinator->diversion_noanswer_status, '"diversion_noanswer_status" should have defaulted to null');
    	$this->assertNull($calldestinator->diversion_noanswer_number, '"diversion_noanswer_number" should have defaulted to null');
    	$this->assertNull($calldestinator->diversion_unavail_duration, '"diversion_unavail_duration" should have defaulted to null');    	 
     }
    
    public function testSettersAndGettersPerformCorrectly()
    {
        $calldestinator = new CallDestinatorEntity();
        $filter = new UnderscoreToCamelCase();
        $data = array(
        				'id' => 1,
        				'name'     => 'testname',
        				'extension'  => '101',
        				'extensiongroup'=>12,
        				'extensiontype'=>'regular',
        				'operatorstatus'=>'online',
        				'outgoingcallspermission'=>'allowed',
        				'transfer'=>'allowed',
        				'statuschange'=>'allowed',
        				'incoming'=> 'allowed',
        				'hold'=> 'allowed',
        				'forwarding'=> 'allowed',
        				'memberofcallcentreque' => 'allowed',
        				'mailbox' => '101',
        				'peertype'=> 'EXTENSION',
        				'routeref'=>1,
        				'number_status'=>'enabled',
        				'diversion_unconditional_status'=>'UNDEFINED',
        				'diversion_unconditional_number'=>'',
        				'diversion_unavail_status'=>'UNDEFINED',
        				'diversion_unavail_number'=>'',
        				'diversion_busy_status'=>'UNDEFINED',
        				'diversion_busy_number'=>'',
        				'diversion_noanswer_status'=>'UNDEFINED',
        				'diversion_noanswer_number'=>'',
        				'diversion_unavail_duration'=>20
        		);
    	foreach ($data as $propertyname=>$propertyvalue)
    	{
    	    $methodNameMutator = 'set'. $filter($propertyname);
    	    $methodNameAccessor = 'get'. $filter($propertyname);
    	    
     	    if (!method_exists($calldestinator, $methodNameMutator))
    	    {
    	    	throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    	    }
    	    if (!method_exists($calldestinator, $methodNameAccessor))
    	    {
   	    	   throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    	    }
    		call_user_func(array($calldestinator,$methodNameMutator),'test');
    		$result = call_user_func(array($calldestinator,$methodNameAccessor));
            $this->assertSame($result, 'test');    		
     	}
    }
    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
    	$calldestinator = new CallDestinatorEntity();
    	$data  =  array(
    	               'id' => 1,
    			       'name'     => 'testname',
    			       'extension'  => '101',
    	               'extensiongroup'=>12,
    	               'extensiontype'=>'regular',
    	               'operatorstatus'=>'online',
    	               'outgoingcallspermission'=>'allowed',
    	               'transfer'=>'allowed',
    	               'statuschange'=>'allowed',
    	               'incoming'=> 'allowed',
    	               'hold'=> 'allowed',
    	               'forwarding'=> 'allowed',
    	               'memberofcallcentreque' => 'allowed',
    	               'mailbox' => '101',
    	               'peertype'=> 'EXTENSION',
    	               'routeref'=>1,
    	               'number_status'=>'enabled',
    	               'diversion_unconditional_status'=>'UNDEFINED',
    	               'diversion_unconditional_number'=>'',
    	               'diversion_unavail_status'=>'UNDEFINED',
    	               'diversion_unavail_number'=>'',
    	               'diversion_busy_status'=>'UNDEFINED',
    	               'diversion_busy_number'=>'',
    	               'diversion_noanswer_status'=>'UNDEFINED',
    	               'diversion_noanswer_number'=>'',
    	               'diversion_unavail_duration'=>20    	                   	
    	           );
    
    	$calldestinator->exchangeArray($data);
    	$copyArray = $calldestinator->getArrayCopy();
    
    	$this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
    	$this->assertSame($data['name'], $copyArray['name'], '"name" was not set correctly');
    	$this->assertSame($data['extension'], $copyArray['extension'], '"extension" was not set correctly');
    	$this->assertSame($data['extensiongroup'], $copyArray['extensiongroup'], '"extensiongroup" was not set correctly');
    	$this->assertSame($data['extensiontype'], $copyArray['extensiontype'], '"extensiontype" was not set correctly');
    	$this->assertSame($data['operatorstatus'], $copyArray['operatorstatus'], '"operatorstatus" was not set correctly');
    	$this->assertSame($data['outgoingcallspermission'], $copyArray['outgoingcallspermission'], '"outgoingcallspermission" was not set correctly');
    	$this->assertSame($data['transfer'], $copyArray['transfer'], '"transfer" was not set correctly');
    	$this->assertSame($data['statuschange'], $copyArray['statuschange'], '"statuschange" was not set correctly');
    	$this->assertSame($data['incoming'], $copyArray['incoming'], '"incoming" was not set correctly');
    	$this->assertSame($data['hold'], $copyArray['hold'], '"hold" was not set correctly');
    	$this->assertSame($data['forwarding'], $copyArray['forwarding'], '"forwarding" was not set correctly');
    	$this->assertSame($data['memberofcallcentreque'], $copyArray['memberofcallcentreque'], '"memberofcallcentreque" was not set correctly');
    	$this->assertSame($data['mailbox'], $copyArray['mailbox'], '"mailbox" was not set correctly');
    	$this->assertSame($data['peertype'], $copyArray['peertype'], '"peertype" was not set correctly');
    	$this->assertSame($data['routeref'], $copyArray['routeref'], '"routeref" was not set correctly');
    	$this->assertSame($data['number_status'], $copyArray['number_status'], '"number_status" was not set correctly');
    	$this->assertSame($data['diversion_unconditional_status'], $copyArray['diversion_unconditional_status'], '"diversion_unconditional_status" was not set correctly');
    	$this->assertSame($data['diversion_unconditional_number'], $copyArray['diversion_unconditional_number'], '"diversion_unconditional_number" was not set correctly');
    	$this->assertSame($data['diversion_unavail_status'], $copyArray['diversion_unavail_status'], '"diversion_unavail_status" was not set correctly');
    	$this->assertSame($data['diversion_unavail_number'], $copyArray['diversion_unavail_number'], '"diversion_unavail_number" was not set correctly');
    	$this->assertSame($data['diversion_busy_status'], $copyArray['diversion_busy_status'], '"diversion_busy_status" was not set correctly');
    	$this->assertSame($data['diversion_busy_number'], $copyArray['diversion_busy_number'], '"diversion_busy_number" was not set correctly');
    	$this->assertSame($data['diversion_noanswer_status'], $copyArray['diversion_noanswer_status'], '"diversion_noanswer_status" was not set correctly');
    	$this->assertSame($data['diversion_noanswer_number'], $copyArray['diversion_noanswer_number'], '"diversion_noanswer_number" was not set correctly');
    	$this->assertSame($data['diversion_unavail_duration'], $copyArray['diversion_unavail_duration'], '"diversion_unavail_duration" was not set correctly');    	 
    }
    
    
    
    
}