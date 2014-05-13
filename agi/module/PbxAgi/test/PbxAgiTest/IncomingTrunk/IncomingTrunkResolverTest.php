<?php
namespace PbxAgiTest\IncomingTrunk;

use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\IncomingTrunk\IncomingTrunkResolverFactory;

class IncomingTrunkResolverTest extends PHPUnit_Framework_TestCase
{
    protected $incomingTrunkResolver;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $factory = new IncomingTrunkResolverFactory();
                
        $this->incomingTrunkResolver = $factory->createService($serviceManager);
                        	      	       	
    }
    public function testIncomingTrunkResolverInjectsInstanceOfElementChain()
    {
        $this->assertInstanceOf('PbxAgi\EntityResolver\Element\RootElement', $this->incomingTrunkResolver->getElementChain());        
    }
   
}