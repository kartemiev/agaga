<?php
namespace PbxAgiTest\FaxSpoolLog\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLog;

class FaxSpoolLogTest extends PHPUnit_Framework_TestCase
{
    public function testFaxSpoolLogInitialState()
    {
        
         $faxspoollog = new FaxSpoolLog();
         $this->assertNull($faxspoollog->id, '"id" should initially be null');
         $this->assertNull($faxspoollog->spoolref, '"spoolref" should initially be null');
         $this->assertNull($faxspoollog->action, '"action" should initially be null');
         $this->assertNull($faxspoollog->result, '"result" should initially be null');
         $this->assertNull($faxspoollog->reason, '"reason" should initially be null');
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$faxspoollog = new FaxSpoolLog();
		$data = array(
  				 'spoolref'=> 2,
		         'action'=> 'тест1',
		         'result'=> 'тест2',
		         'reason'=> 'тест3'		    
		    );
         $faxspoollog->exchangeArray($data);

          $this->assertSame($data['spoolref'], $faxspoollog->spoolref, '"spoolref" was not set correctly');
         $this->assertSame($data['action'], $faxspoollog->action, '"action" was not set correctly');
         $this->assertSame($data['result'], $faxspoollog->result, '"result" was not set correctly');
         $this->assertSame($data['reason'], $faxspoollog->reason, '"reason" was not set correctly');
          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$faxspoollog = new FaxSpoolLog();
    	
        $faxspoollog->exchangeArray(array(
 		         'id'=> 1,
 				 'spoolref'=> 'тест',
		         'action'=> 'тест',
		         'result'=> 'тест',
		         'reason'=> 1		    
                        ));
        $faxspoollog->exchangeArray(array());
    
        $this->assertNull($faxspoollog->id, '"id" should have defaulted to null');
        $this->assertNull($faxspoollog->spoolref, '"spoolref" should have defaulted to null');
        $this->assertNull($faxspoollog->action, '"action" should have defaulted to null');
        $this->assertNull($faxspoollog->result, '"result" should have defaulted to null');
        $this->assertNull($faxspoollog->reason, '"reason" should have defaulted to null');
         
             }
}
