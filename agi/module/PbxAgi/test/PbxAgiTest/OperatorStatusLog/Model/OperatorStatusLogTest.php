<?php
namespace PbxAgiTest\OperatorStatusLog\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\OperatorStatusLog\Model\OperatorStatusLog;
use Zend\Filter\Word\UnderscoreToCamelCase;

class OperatorStatusLogTest extends PHPUnit_Framework_TestCase
{    
    
    public function testOperatorStatusLogInitialState()
    {        
         $operatorstatuslog = new OperatorStatusLog();
         $this->assertNull($operatorstatuslog->extension, '"extension" should initially be null');
         $this->assertNull($operatorstatuslog->operatorstatus, '"operatorstatus" should initially be null');
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $operatorstatuslog = new OperatorStatusLog();
                
        $data = array(		          
		         'extension'=> '100',
		         'operatorstatus'=> 'lanch_away',		    
		    );
         $operatorstatuslog->exchangeArray($data);

         $this->assertSame($data['extension'], $operatorstatuslog->extension, '"extension" was not set correctly');
         $this->assertSame($data['operatorstatus'], $operatorstatuslog->operatorstatus, '"operatorstatus" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $operatorstatuslog = new OperatorStatusLog();
                 
        $operatorstatuslog->exchangeArray(array(		          
		         'extension'=> '100',
		         'operatorstatus'=> 'lanch_away',		    
		    ));
        
        $operatorstatuslog->exchangeArray(array());
    
        $this->assertNull($operatorstatuslog->extension, '"extension" should have defaulted to null');
        $this->assertNull($operatorstatuslog->operatorstatus, '"operatorstatus" should have defaulted to null');         
      
    }
    
    public function testSettersAndGettersPerformCorrectly()
    {
    	$operatorstatuslog = new OperatorStatusLog();
    	$filter = new UnderscoreToCamelCase();
        $data = array(		          
		         'extension'=> '100',
		         'operatorstatus'=> 'lanch_away',		    
		    );
    	foreach ($data as $propertyname=>$propertyvalue)
    	{
    		$methodNameMutator = 'set'. $filter($propertyname);
    		$methodNameAccessor = 'get'. $filter($propertyname);
    		 
    		if (!method_exists($operatorstatuslog, $methodNameMutator))
    		{
    			throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    		}
    		if (!method_exists($operatorstatuslog, $methodNameAccessor))
    		{
    			throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    		}
    		call_user_func(array($operatorstatuslog,$methodNameMutator),'test');
    		$result = call_user_func(array($operatorstatuslog,$methodNameAccessor));
    		$this->assertSame($result, 'test');
    	}
    }
}
