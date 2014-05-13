<?php
namespace PbxAgiTest\Service\ClientImpl;
 
use PHPUnit_Framework_TestCase;
use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\Service\ClientImpl\Peer;

class PeerTest extends PHPUnit_Framework_TestCase
{
    public function testMediaInitialState()
    {        
         $peer = new Peer('SIP', '0001');
         $this->assertSame('SIP',$peer->technology, '"technology" should initially be null');
         $this->assertSame('0001',$peer->name, '"name" should initially be null');
     }

    public function testSettersAndGettersPerformCorrectly()
    {
        $peer = new Peer('IAX','10002');
        
        $data = array(
        	'technology'=>'',
            'name'=>''
        );
        
    	$filter = new UnderscoreToCamelCase();

    	$unuqueSeq = 0;
    	
    	foreach ($data as $propertyname=>$propertyvalue)
    	{
    	    $unuqueSeq++;
    		$methodNameMutator = 'set'. $filter($propertyname);
    		$methodNameAccessor = 'get'. $filter($propertyname);
    
    		if (!method_exists($peer, $methodNameMutator))
    		{
    			throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    		}
    		if (!method_exists($peer, $methodNameAccessor))
    		{
    			throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    		}
    		call_user_func(array($peer,$methodNameMutator),'test'.$unuqueSeq);
    		$result = call_user_func(array($peer,$methodNameAccessor));
    		$this->assertSame($result, 'test'.$unuqueSeq);
    	}
    }
     
}
