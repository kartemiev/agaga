<?php
namespace PbxAgiTest\ExtensionDefaults\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\ExtensionDefaults\Model\ExtensionDefaults;


class ExtensionDefaultsTest extends PHPUnit_Framework_TestCase
{
    
    public function testExtensionDefaultsInitialState()
    {
        $extensiondefaults = new ExtensionDefaults();
         $this->assertNull($extensiondefaults->vpbxid, '"vpbxid" should initially be null');
         $this->assertNull($extensiondefaults->transfer, '"transfer" should initially be null');
         $this->assertNull($extensiondefaults->statuschange, '"statuschange" should initially be null');
         $this->assertNull($extensiondefaults->hold, '"hold" should initially be null');
         $this->assertNull($extensiondefaults->forwarding, '"forwarding" should initially be null');
         $this->assertNull($extensiondefaults->number_status, '"number_status" should initially be null');
         $this->assertNull($extensiondefaults->diversion_unconditional_status, '"diversion_unconditional_status" should initially be null');
         $this->assertNull($extensiondefaults->diversion_unconditional_number, '"diversion_unconditional_number" should initially be null');
         $this->assertNull($extensiondefaults->diversion_unavail_status, '"diversion_unavail_status" should initially be null');
         $this->assertNull($extensiondefaults->diversion_busy_status, '"diversion_busy_status" should initially be null');
         $this->assertNull($extensiondefaults->diversion_busy_number, '"diversion_busy_number" should initially be null');
         $this->assertNull($extensiondefaults->diversion_noanswer_status, '"diversion_noanswer_status" should initially be null');
         $this->assertNull($extensiondefaults->diversion_noanswer_number, '"diversion_noanswer_number" should initially be null');
         $this->assertNull($extensiondefaults->diversion_unconditional_landingtype, '"diversion_unconditional_landingtype" should initially be null');         
         $this->assertNull($extensiondefaults->diversion_unavail_landingtype, '"diversion_unavail_landingtype" should initially be null');
         $this->assertNull($extensiondefaults->diversion_busy_landingtype, '"diversion_busy_landingtype" should initially be null');
         $this->assertNull($extensiondefaults->diversion_noanswer_landingtype, '"diversion_noanswer_landingtype" should initially be null');
         $this->assertNull($extensiondefaults->diversion_noanswer_duration, '"diversion_noanswer_duration" should initially be null');
         $this->assertNull($extensiondefaults->outgoingcallspermission, '"outgoingcallspermission" should initially be null');          
         $this->assertNull($extensiondefaults->extensionrecord, '"extensionrecord" should initially be null');
          
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$extensiondefaults = new ExtensionDefaults();
		$data = array(
             'transfer'=>'allowed',
            'statuschange'=>'allowed',
            'incoming'=>'allowed',
            'hold'=>'allowed',
            'forwarding'=>'allowed',
            'number_status'=>'allowed',
            'diversion_unconditional_status'=>'UNDEFINED',
            'diversion_unconditional_number'=>'',
            'diversion_unavail_status'=>'UNDEFINED',
            'diversion_unavail_number'=>'',
            'diversion_busy_status'=>'UNDEFINED',
            'diversion_busy_number'=>'',
            'diversion_noanswer_status'=>'UNDEFINED',
            'diversion_noanswer_number'=>'',    
            'diversion_unconditional_landingtype'=>'',
            'diversion_unavail_landingtype'=>'',
            'diversion_busy_landingtype'=>'',
            'diversion_noanswer_landingtype'=>'',
            'diversion_noanswer_duration'=>30,
            'outgoingcallspermission'=> 'allowed',
            'extensionrecord'=> 'enabled'		    
		);
         $extensiondefaults->exchangeArray($data);

         $this->assertSame($data['transfer'], $extensiondefaults->transfer, '"transfer" was not set correctly');
         $this->assertSame($data['statuschange'], $extensiondefaults->statuschange, '"statuschange" was not set correctly');
         $this->assertSame($data['incoming'], $extensiondefaults->incoming, '"incoming" was not set correctly');
         $this->assertSame($data['hold'], $extensiondefaults->hold, '"hold" was not set correctly');
         $this->assertSame($data['forwarding'], $extensiondefaults->forwarding, '"forwarding" was not set correctly');
         $this->assertSame($data['number_status'], $extensiondefaults->number_status, '"number_status" was not set correctly');
         $this->assertSame($data['diversion_unconditional_status'], $extensiondefaults->diversion_unconditional_status, '"diversion_unconditional_status" was not set correctly');
         $this->assertSame($data['diversion_unconditional_number'], $extensiondefaults->diversion_unconditional_number, '"diversion_unconditional_number" was not set correctly');         
         $this->assertSame($data['diversion_unavail_status'], $extensiondefaults->diversion_unavail_status, '"diversion_unavail_status" was not set correctly');
         $this->assertSame($data['diversion_unavail_number'], $extensiondefaults->diversion_unavail_number, '"diversion_unavail_number" was not set correctly');
         $this->assertSame($data['diversion_busy_status'], $extensiondefaults->diversion_busy_status, '"diversion_busy_status" was not set correctly');
         $this->assertSame($data['diversion_busy_number'], $extensiondefaults->diversion_busy_number, '"diversion_busy_number" was not set correctly');
         $this->assertSame($data['diversion_noanswer_status'], $extensiondefaults->diversion_noanswer_status, '"diversion_noanswer_status" was not set correctly');
         $this->assertSame($data['diversion_noanswer_number'], $extensiondefaults->diversion_noanswer_number, '"diversion_noanswer_number" was not set correctly');          
         $this->assertSame($data['diversion_unconditional_landingtype'], $extensiondefaults->diversion_unconditional_landingtype, '"diversion_unconditional_landingtype" was not set correctly');
         $this->assertSame($data['diversion_unavail_landingtype'], $extensiondefaults->diversion_unavail_landingtype, '"diversion_unavail_landingtype" was not set correctly');          
         $this->assertSame($data['diversion_busy_landingtype'], $extensiondefaults->diversion_busy_landingtype, '"diversion_busy_landingtype" was not set correctly');
         $this->assertSame($data['diversion_noanswer_landingtype'], $extensiondefaults->diversion_noanswer_landingtype, '"diversion_noanswer_landingtype" was not set correctly');
         $this->assertSame($data['diversion_noanswer_duration'], $extensiondefaults->diversion_noanswer_duration, '"diversion_noanswer_duration" was not set correctly');          
         $this->assertSame($data['outgoingcallspermission'], $extensiondefaults->outgoingcallspermission, '"outgoingcallspermission" was not set correctly');
         $this->assertSame($data['extensionrecord'], $extensiondefaults->extensionrecord, '"extensionrecord" was not set correctly');
          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$extensiondefaults = new ExtensionDefaults();
    	
        $extensiondefaults->exchangeArray(array(
            'vpbxid'=>1,
            'transfer'=>'allowed',
            'statuschange'=>'allowed',
            'incoming'=>'allowed',
            'hold'=>'allowed',
            'forwarding'=>'allowed',
            'number_status'=>'allowed',
            'diversion_unconditional_status'=>'UNDEFINED',
            'diversion_unconditional_number'=>'',
            'diversion_unavail_status'=>'UNDEFINED',
            'diversion_unavail_number'=>'',
            'diversion_busy_status'=>'UNDEFINED',
            'diversion_busy_number'=>'',
            'diversion_noanswer_status'=>'UNDEFINED',
            'diversion_noanswer_number'=>'',    
            'diversion_unconditional_landingtype'=>'',
            'diversion_unavail_landingtype'=>'',
            'diversion_busy_landingtype'=>'',
            'diversion_noanswer_landingtype'=>'',
            'diversion_noanswer_duration'=>30,
            'outgoingcallspermission'=> 'allowed',
            'extensionrecord'=> 'enabled'		                		    
		));
        $extensiondefaults->exchangeArray(array());
    
        $this->assertNull($extensiondefaults->vpbxid, '"vpbxid" should have defaulted to null');        
        $this->assertNull($extensiondefaults->transfer, '"transfer" should have defaulted to null');
        $this->assertNull($extensiondefaults->statuschange, '"statuschange" should have defaulted to null');
        $this->assertNull($extensiondefaults->incoming, '"incoming" should have defaulted to null');
        $this->assertNull($extensiondefaults->hold, '"hold" should have defaulted to null');
        $this->assertNull($extensiondefaults->forwarding, '"forwarding" should have defaulted to null');
        $this->assertNull($extensiondefaults->number_status, '"number_status" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_unconditional_status, '"diversion_unconditional_status" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_unconditional_number, '"diversion_unconditional_number" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_unavail_status, '"diversion_unavail_status" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_unavail_number, '"diversion_unavail_number" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_busy_status, '"diversion_busy_status" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_busy_number, '"diversion_busy_number" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_noanswer_status, '"diversion_noanswer_status" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_noanswer_number, '"diversion_noanswer_number" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_unconditional_landingtype, '"diversion_unconditional_landingtype" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_unavail_landingtype, '"diversion_unavail_landingtype" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_busy_landingtype, '"diversion_busy_landingtype" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_noanswer_landingtype, '"diversion_noanswer_landingtype" should have defaulted to null');
        $this->assertNull($extensiondefaults->diversion_noanswer_duration, '"diversion_noanswer_duration" should have defaulted to null');
        $this->assertNull($extensiondefaults->outgoingcallspermission, '"outgoingcallspermission" should have defaulted to null');
        $this->assertNull($extensiondefaults->extensionrecord, '"extensionrecord" should have defaulted to null');
        
             }
             
      public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
             {
             	$extensiondefaults = new ExtensionDefaults();
             	$data  = array(
             'transfer'=>'allowed',
            'statuschange'=>'allowed',
            'incoming'=>'allowed',
            'hold'=>'allowed',
            'forwarding'=>'allowed',
            'number_status'=>'allowed',
            'diversion_unconditional_status'=>'UNDEFINED',
            'diversion_unconditional_number'=>'',
            'diversion_unavail_status'=>'UNDEFINED',
            'diversion_unavail_number'=>'',
            'diversion_busy_status'=>'UNDEFINED',
            'diversion_busy_number'=>'',
            'diversion_noanswer_status'=>'UNDEFINED',
            'diversion_noanswer_number'=>'',    
            'diversion_unconditional_landingtype'=>'',
            'diversion_unavail_landingtype'=>'',
            'diversion_busy_landingtype'=>'',
            'diversion_noanswer_landingtype'=>'',
            'diversion_noanswer_duration'=>30,
            'outgoingcallspermission'=> 'allowed',
            'extensionrecord'=> 'enabled'		    
		);
             
             	$extensiondefaults->exchangeArray($data);
             	$copyArray = $extensiondefaults->getArrayCopy();
             
             	$this->assertSame($data['transfer'], $copyArray['transfer'], '"transfer" was not set correctly');
             	$this->assertSame($data['statuschange'], $copyArray['statuschange'], '"statuschange" was not set correctly');
             	$this->assertSame($data['incoming'], $copyArray['incoming'], '"incoming" was not set correctly');
             	$this->assertSame($data['hold'], $copyArray['hold'], '"hold" was not set correctly');
             	$this->assertSame($data['forwarding'], $copyArray['forwarding'], '"forwarding" was not set correctly');
             	$this->assertSame($data['number_status'], $copyArray['number_status'], '"number_status" was not set correctly');
             	$this->assertSame($data['diversion_unconditional_status'], $copyArray['diversion_unconditional_status'], '"diversion_unconditional_status" was not set correctly');
             	$this->assertSame($data['diversion_unconditional_number'], $copyArray['diversion_unconditional_number'], '"diversion_unconditional_number" was not set correctly');
             	$this->assertSame($data['diversion_unavail_status'], $copyArray['diversion_unavail_status'], '"diversion_unavail_status" was not set correctly');
             	$this->assertSame($data['diversion_unavail_number'], $copyArray['diversion_unavail_number'], '"diversion_busy_number" was not set correctly');
             	$this->assertSame($data['diversion_busy_status'], $copyArray['diversion_busy_status'], '"diversion_busy_status" was not set correctly');
             	$this->assertSame($data['diversion_busy_number'], $copyArray['diversion_busy_number'], '"diversion_busy_number" was not set correctly');
             	$this->assertSame($data['diversion_noanswer_status'], $copyArray['diversion_noanswer_status'], '"diversion_noanswer_status" was not set correctly');
             	$this->assertSame($data['diversion_noanswer_number'], $copyArray['diversion_noanswer_number'], '"diversion_noanswer_number" was not set correctly');
             	$this->assertSame($data['diversion_unconditional_landingtype'], $copyArray['diversion_unconditional_landingtype'], '"diversion_unconditional_landingtype" was not set correctly');
             	$this->assertSame($data['diversion_unavail_landingtype'], $copyArray['diversion_unavail_landingtype'], '"diversion_unavail_landingtype" was not set correctly');
             	$this->assertSame($data['diversion_busy_landingtype'], $copyArray['diversion_busy_landingtype'], '"diversion_busy_landingtype" was not set correctly');
             	$this->assertSame($data['diversion_noanswer_landingtype'], $copyArray['diversion_noanswer_landingtype'], '"diversion_noanswer_landingtype" was not set correctly');
             	$this->assertSame($data['diversion_noanswer_duration'], $copyArray['diversion_noanswer_duration'], '"diversion_noanswer_duration" was not set correctly');
             	$this->assertSame($data['outgoingcallspermission'], $copyArray['outgoingcallspermission'], '"outgoingcallspermission" was not set correctly');
             	$this->assertSame($data['extensionrecord'], $copyArray['extensionrecord'], '"extensionrecord" was not set correctly');
             }     
}
