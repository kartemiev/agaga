<?php
namespace PbxAgiTest\Validator\Extension;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Validator\Extension\ExtensionRegexValidator;

class ExtensionRegexValidatorTest extends PHPUnit_Framework_TestCase
{
	public function testExtensionRegexValidatorCanReturnTrueOnValidInput()
	{
	    $extensionRegexValidator = new ExtensionRegexValidator();
	    $this->assertTrue($extensionRegexValidator->isValid('300'),'Exentsion Regex Validator should return true on valid input');
	}
	public function testExtensionRegexValidatorCanReturnFalseOnInvalidInput()
	{
		$extensionRegexValidator = new ExtensionRegexValidator();
		$this->assertFalse($extensionRegexValidator->isValid('3003'),'Exentsion Regex Validator should return false on invalid input');
	}
	
}