<?php
namespace PbxAgiTest\Media\Model;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\Media\Model\Media;
use Zend\Filter\Word\UnderscoreToCamelCase;

class MediaTest extends PHPUnit_Framework_TestCase
{
    public function testMediaInitialState()
    {        
         $media = new Media();
         $this->assertNull($media->id, '"id" should initially be null');
         $this->assertNull($media->filename, '"filename" should initially be null');
         $this->assertNull($media->mediatype, '"mediatype" should initially be null');
     }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
		$media = new Media();
		$data = array(		          
		         'filename'=> 'test.mp3',
		         'mediatype'=> 'application/mpeg'		    
		    );
         $media->exchangeArray($data);

         $this->assertSame($data['filename'], $media->filename, '"filename" was not set correctly');
         $this->assertSame($data['mediatype'], $media->mediatype, '"mediatype" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
		$media = new Media();
            	
        $media->exchangeArray(array(
		         'filename'=> 'test.mp3',
		         'mediatype'=> 'application/mpeg'
                                            ));
        $media->exchangeArray(array());
    
        $this->assertNull($media->id, '"id" should have defaulted to null');
        $this->assertNull($media->filename, '"filename" should have defaulted to null');
        $this->assertNull($media->mediatype, '"mediatype" should have defaulted to null');         

    }
    public function testSettersAndGettersPerformCorrectly()
    {
        $media = new Media();
        $data = array(
                'id'=>1,
        		'filename'=> 'test.mp3',
        		'mediatype'=> 'application/mpeg'
        );
        
    	$filter = new UnderscoreToCamelCase();
    	 
    	foreach ($data as $propertyname=>$propertyvalue)
    	{
    		$methodNameMutator = 'set'. $filter($propertyname);
    		$methodNameAccessor = 'get'. $filter($propertyname);
    
    		if (!method_exists($media, $methodNameMutator))
    		{
    			throw new \Exception('method '.$methodNameMutator.' doesnt exist');
    		}
    		if (!method_exists($media, $methodNameAccessor))
    		{
    			throw new \Exception('method '.$methodNameAccessor.' doesnt exist');
    		}
    		call_user_func(array($media,$methodNameMutator),'test');
    		$result = call_user_func(array($media,$methodNameAccessor));
    		$this->assertSame($result, 'test');
    	}
    }
    public function testGetArrayCopyPerformsCorrectly()
    {
    	$media = new Media();
    	$this->assertSame(get_object_vars($media), $media->getArrayCopy(), 'getArrayCopy should return array copy of Media porperties');
    }
}
