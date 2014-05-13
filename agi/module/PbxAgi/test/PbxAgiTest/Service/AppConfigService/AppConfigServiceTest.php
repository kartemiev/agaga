<?php
namespace PbxAgiTest\Service\AppConfigService;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\Extension\Model\Extension;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\Service\AppConfig\AppConfigService;


class AppConfigServiceTest extends PHPUnit_Framework_TestCase
{
    public function testSettersAndGettersPerformCorrectly()
    {
    	$appconfig = new AppConfigService();
    
    
    	$filter = new UnderscoreToCamelCase();
    
    	$unuqueSeq = 0;
    	 
    	foreach ($appconfig as $propertyname=>$propertyvalue)
    	{
    		$unuqueSeq++;
    		$methodNameMutator = 'set'. $filter($propertyname);
    		$methodNameAccessor = 'get'. $filter($propertyname);
    
    		if (!method_exists($appconfig, $methodNameMutator))
    		{
    			throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    		}
    		if (!method_exists($appconfig, $methodNameAccessor))
    		{
    			throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    		}
    		$testValue = 'test'.$unuqueSeq;
    		call_user_func(array($appconfig,$methodNameMutator),$testValue);
    		$this->assertTrue($testValue==call_user_func(array($appconfig,$methodNameAccessor)));
    	}
    }
     
}
