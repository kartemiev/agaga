<?php
namespace PbxAgiTest\Service\CallSpoolImpl;
 
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\CallSpoolImpl\CallSpoolImplFactory;

class CallSpoolImplTest extends PHPUnit_Framework_TestCase
{
     protected $callSpoolImplFactory;
     public function setUp()
     {
     	$factory = new CallSpoolImplFactory();
     	$this->callSpoolImplFactory = $factory->getInstance(array());
     }
     public function testFactoryReturnsInstanceOfCallSpoolImpl()
     {
     	$this->setUp();
     	$this->assertInstanceOf('PAGI\CallSpool\Impl\CallSpoolImpl', $this->callSpoolImplFactory);
     }
     
}
