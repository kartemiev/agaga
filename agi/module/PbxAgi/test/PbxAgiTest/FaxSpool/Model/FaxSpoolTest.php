<?php
namespace PbxAgiTest\FaxSpoolTest\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\FaxSpool\Model\FaxSpool;
use Zend\Filter\Word\UnderscoreToCamelCase;

class FaxSpoolTest extends PHPUnit_Framework_TestCase
{
    public function testFaxSpoolInitialState()
    {
         $faxspool = new FaxSpool();
         $this->assertNull($faxspool->id, '"id" should initially be null');
         $this->assertNull($faxspool->recordtype, '"recordtype" should initially be null');
         $this->assertNull($faxspool->uniqueid, '"uniqueid" should initially be null');
         $this->assertNull($faxspool->faxstatus, '"faxstatus" should initially be null');
         $this->assertNull($faxspool->pages, '"pages" should initially be null');
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$faxspool = new FaxSpool();
		$data = array(
 				 'recordtype'=> 'тест',
		         'uniqueid'=> 'тест',
		         'faxstatus'=> 'тест',
		         'pages'=> 1		    
		    );
         $faxspool->exchangeArray($data);
         $this->assertSame($data['recordtype'], $faxspool->recordtype, '"recordtype" was not set correctly');
         $this->assertSame($data['uniqueid'], $faxspool->uniqueid, '"uniqueid" was not set correctly');
         $this->assertSame($data['faxstatus'], $faxspool->faxstatus, '"faxstatus" was not set correctly');
         $this->assertSame($data['pages'], $faxspool->pages, '"pages" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$faxspool = new FaxSpool();
    	
        $faxspool->exchangeArray(array(
 		         'id'=> 1,
 				 'recordtype'=> 'тест',
		         'uniqueid'=> 'тест',
		         'faxstatus'=> 'тест',
		         'pages'=> 1		    
                        ));
        $faxspool->exchangeArray(array());    
        $this->assertNull($faxspool->id, '"id" should have defaulted to null');
        $this->assertNull($faxspool->recordtype, '"recordtype" should have defaulted to null');
        $this->assertNull($faxspool->uniqueid, '"uniqueid" should have defaulted to null');
        $this->assertNull($faxspool->faxstatus, '"faxstatus" should have defaulted to null');
        $this->assertNull($faxspool->pages, '"pages" should have defaulted to null');         
    }
    public function testSettersAndGettersPerformCorrectly()
    {
    	$faxspool = new FaxSpool();
    	$filter = new UnderscoreToCamelCase();
    	 
    	foreach ($faxspool as $propertyname=>$propertyvalue)
    	{
    		$methodNameMutator = 'set'. $filter($propertyname);
    		$methodNameAccessor = 'get'. $filter($propertyname);
    		 
    		if (!method_exists($faxspool, $methodNameMutator))
    		{
    			throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    		}
    		if (!method_exists($faxspool, $methodNameAccessor))
    		{
    			throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    		}
    		call_user_func(array($faxspool,$methodNameMutator),'test');
    		$result = call_user_func(array($faxspool,$methodNameAccessor));
    		$this->assertSame($result, 'test');
    	}
    }
}
