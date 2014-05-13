<?php
namespace PbxAgiTest\Route\Model;

use PbxAgi\Route\Model\Route;

use PHPUnit_Framework_TestCase;

class RouteTest extends PHPUnit_Framework_TestCase
{
    public function testRouteInitialState()
    {
        $route = new Route();
        $this->assertNull($route->id, '"id" should initially be null');
        $this->assertNull($route->custname, '"custname" should initially be null');
        $this->assertNull($route->custdesc, '"custdesc" should initially be null');
        $this->assertNull($route->isdefault, '"isdefault" should initially be null');       
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $route = new Route();
        $data  = array(        		
        		'id'     => 10,
        		'custname'=>'ТФОП 4997777777',
        		'custdesc'=>NULL,
        		'isdefault'=>true            
        );

        $route->exchangeArray($data);

         $this->assertSame($data['id'], $route->id, '"id" was not set correctly');
         $this->assertSame($data['custname'], $route->custname, '"custname" was not set correctly');
         $this->assertSame($data['custdesc'], $route->custdesc, '"custdesc" was not set correctly');
         $this->assertSame($data['isdefault'], $route->isdefault, '"isdefault" was not set correctly');          
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $route = new Route();

        $route->exchangeArray(array(
        		'id'     => 10,
        		'custname'=>'ТФОП 4997777777',
        		'custdesc'=>NULL,
        		'isdefault'=>true        		 
            ));
        $route->exchangeArray(array());
    
        $this->assertNull($route->id, '"id" should have defaulted to null');
        $this->assertNull($route->custname, '"custname" should have defaulted to null');
        $this->assertNull($route->custdesc, '"custdesc" should have defaulted to null');
        $this->assertNull($route->isdefault, '"isdefault" should have defaulted to null');        
            }
            
            
     public function testGetArrayCopyPerformsCorrectly()
     {
        $route = new Route();
        $this->assertSame(get_object_vars($route), $route->getArrayCopy(), 'ArrayCopy should return array copy of Route porperties');
    }
}
