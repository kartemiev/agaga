<?php
namespace PbxAgiTest\FaxUser\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\FaxUser\Model\FaxUser;

class FaxUserTest extends PHPUnit_Framework_TestCase
{
    public function testFaxUserInitialState()
    {
        
         $faxuser = new FaxUser();
         $this->assertNull($faxuser->id, '"id" should initially be null');
         $this->assertNull($faxuser->custname, '"custname" should initially be null');
         $this->assertNull($faxuser->email, '"email" should initially be null');
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$faxuser = new FaxUser();
		$data = array(
		         'custname'=> 'тест1',
		         'email'=> 'тест1'		    
		    );
         $faxuser->exchangeArray($data);

         $this->assertSame($data['custname'], $faxuser->custname, '"custname" was not set correctly');
         $this->assertSame($data['email'], $faxuser->email, '"email" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$faxuser = new FaxUser();
    	
        $faxuser->exchangeArray(array(
 		         'id'=> 1,
		         'custname'=> 'тест1',
		         'email'=> 'тест1'		    
                                    ));
        $faxuser->exchangeArray(array());
    
        $this->assertNull($faxuser->id, '"id" should have defaulted to null');
        $this->assertNull($faxuser->custname, '"custname" should have defaulted to null');
        $this->assertNull($faxuser->email, '"email" should have defaulted to null');
         
     }
}
