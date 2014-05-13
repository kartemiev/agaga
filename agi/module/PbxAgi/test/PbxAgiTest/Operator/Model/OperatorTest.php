<?php
namespace PbxAgiTest\Operator\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\Operator\Model\Operator;
use Zend\Filter\Word\UnderscoreToCamelCase;
 
class OperatorTest extends PHPUnit_Framework_TestCase
{    
    public function testOperatorInitialState()
    {        
         $operator = new Operator();
         $this->assertNull($operator->id, '"id" should initially be null');
         $this->assertNull($operator->extension, '"custname" should initially be null');
         $this->assertNull($operator->extensiontype, '"regentries" should initially be null');
         $this->assertNull($operator->name, '"custdesc" should initially be null');          
         $this->assertNull($operator->operatorstatus, '"operatorstatus" should initially be null');          
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $operator = new Operator();
        
        $data = array(		          
		         'extension'=> '100',
		         'extensiontype'=> 'REGULAR',		    
                 'name'=> 'Сидоров',
                 'operatorstatus'=> 'online'            
		    );
         $operator->exchangeArray($data);

         $this->assertSame($data['extension'], $operator->extension, '"extension" was not set correctly');
         $this->assertSame($data['extensiontype'], $operator->extensiontype, '"extensiontype" was not set correctly');          
         $this->assertSame($data['name'], $operator->name, '"name" was not set correctly');          
         $this->assertSame($data['operatorstatus'], $operator->operatorstatus, '"operatorstatus" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $operator = new Operator();
         
        $operator->exchangeArray(array(
        		'extension'=> '100',
        		'extensiontype'=> 'REGULAR',
        		'name'=> 'Сидоров',
        		'operatorstatus'=> 'online'
        ));
        
        $operator->exchangeArray(array());
    
        $this->assertNull($operator->id, '"id" should have defaulted to null');
        $this->assertNull($operator->extension, '"extension" should have defaulted to null');
        $this->assertNull($operator->extensiontype, '"extensiontype" should have defaulted to null');         
        $this->assertNull($operator->name, '"name" should have defaulted to null');        
        $this->assertNull($operator->operatorstatus, '"operatorstatus" should have defaulted to null');
        
    }
    public function testSettersAndGettersPerformCorrectly()
    {
        $operator = new Operator();
       	$filter = new UnderscoreToCamelCase();
    
    	foreach ($operator as $propertyname=>$propertyvalue)
    	{
    		$methodNameMutator = 'set'. $filter($propertyname);
    		$methodNameAccessor = 'get'. $filter($propertyname);
    			
    		if (!method_exists($operator, $methodNameMutator))
    		{
    			throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    		}
    		if (!method_exists($operator, $methodNameAccessor))
    		{
    			throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    		}
    		call_user_func(array($operator,$methodNameMutator),'test');
    		$result = call_user_func(array($operator,$methodNameAccessor));
    		$this->assertSame($result, 'test');
    	}
    }
    public function testGetArrayCopyPerformsCorrectly()
    {
    	$operator = new Operator();
    	$this->assertSame(get_object_vars($operator), $operator->getArrayCopy(), 'ArrayCopy should return array copy of Operator porperties');
    }
    
}
