<?php
namespace PbxAgiTest\Conference\Model;

use PHPUnit_Framework_TestCase;
use \PbxAgiTest\Bootstrap;
use PbxAgi\Conference\Model\ConferenceValidator;


class ConferenceValidatorTest extends PHPUnit_Framework_TestCase
{
	public function testConferenceValidatorReturnsCorrectValue()
	{
	    $mockedConferenceTable = $this->getMockBuilder('PbxAgi\Conference\Model\ConferenceTable')
	                                  ->disableOriginalConstructor()
        						      ->getMock();
	    
	    $mockedConferenceTable->expects($this->once())
	                          ->method('isValid')
	                          ->with('5101')
	                          ->will($this->returnValue(true));
	    $conferenceValidator  = new ConferenceValidator($mockedConferenceTable);
        $this->assertTrue($conferenceValidator->isValid('5101'));        	     
	}
}