<?php
namespace PbxAgiTest\Media\Model;

use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;
use PbxAgi\Media\Model\MediaTable;
use PbxAgi\Media\Model\Media;

class MediaTableTest extends PHPUnit_Framework_TestCase
{
	public function testCanSaveMedia()
	{
	   $data = array(		          
		         'filename'=> 'test.mp3',
		         'mediatype'=> 'application/mpeg'		    
		    );
 	    
		$mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
		
		$mockTableGateway->expects($this->once())
		                 ->method('insert')
		                 ->with($data)
		                 ->will($this->returnValue(null));

		$mediaTable = new MediaTable($mockTableGateway);
	    $media = new Media();
		$media->exchangeArray($data);
		$mediaTable->saveMedia($media);		
	}
 }