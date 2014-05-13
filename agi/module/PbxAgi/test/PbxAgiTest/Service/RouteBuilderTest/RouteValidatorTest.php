<?php
namespace PbxAgiTest\Service\RouteBuilderTest;
use \PbxAgiTest\Bootstrap;
use PHPUnit_Framework_TestCase;
use PbxAgi\Service\RouteBuilder\RouteValidatorFactory;
use PbxAgi\Route\Model\Route;
use Zend\Db\ResultSet\ResultSet;

class RouteValidatorTest extends PHPUnit_Framework_TestCase
{
	protected $routeValidator;
	protected $mockedRouteTable;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         
         
        $mockedRouteTable = $this->getMock('PbxAgi\Route\Model\RouteTable',
        		array('fetchAll','getRoute'), array(), '', false);
        
        $serviceManager->setService('PbxAgi\Route\Model\RouteTable', $mockedRouteTable);
        
        $this->mockedRouteTable = $mockedRouteTable;
        
        $factory = new RouteValidatorFactory();
                
        $this->routeValidator = $factory->createService($serviceManager);        
    }
    public function testRouteValidatorReturnsTrueOnValidInput()
    {
        $route = new Route();
        $data = array(
            'id'=>10,
            'custname'=>'стандартный',
            'custdesc'=>'',
            'destinations'=>12,
            'isdefault'=>true            
        );
        $route->exchangeArray($data);
        $this->mockedRouteTable->expects($this->once())
                               ->method('getRoute')
                               ->with(10)
                               ->will($this->returnValue($route));

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Route());
        $resultSet->initialize(array($route));
        
         
        $routeValidator = $this->routeValidator;
        $this->assertSame($route, $routeValidator->validate(10), 'Route validator should have returned true on valid route');
        $this->assertNull($routeValidator->getDefaultRoute(), 'Route validator should have returned null default route when Route is found');
        
    }
    public function testRouteValidatorReturnsDefaultRouteWhenRouteNotFound()
    {
    	$this->mockedRouteTable->expects($this->once())
    	->method('getRoute')
    	->with(10)
    	->will($this->returnValue(null));

    	$data = array(
    			'id'=>15,
    			'custname'=>'стандартный',
    			'custdesc'=>'',
    			'destinations'=>12,
    			'isdefault'=>true
    	);
    	$route = new Route();
    	$route->exchangeArray($data);
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Route());
    	$resultSet->initialize(array($route));
    
    	$this->mockedRouteTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('isdefault'=>true))
    	->will($this->returnValue($resultSet));
    
    	 
    	$routeValidator = $this->routeValidator;
    	$this->assertNull($routeValidator->validate(10), 'Route validator should have returned null when route not found');
    	$this->assertSame(15, $routeValidator->getDefaultRoute(), 'Route validator should have returned default route on request');
    
    }
    public function testRouteValidatorThrowsAnExceptionWhenNeitherRouteNorDefaultRouteIsFound()
    {
    	$this->mockedRouteTable->expects($this->once())
    	->method('getRoute')
    	->with(10)
    	->will($this->returnValue(null));
    
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new Route());
    	$resultSet->initialize(array());
    
    	$this->mockedRouteTable->expects($this->once())
    	                       ->method('fetchAll')
    	                       ->with(array('isdefault'=>true))
    	                       ->will($this->returnValue($resultSet));
    
    	try
    	{
    	   $this->routeValidator->validate(10);
    	}
    	catch (\Exception $e)
    	{
    		$this->assertSame('Neither route not found nor default route defined!', $e->getMessage());
    		return;
    	}
    	
    	$this->fail('Expected exception was not thrown');
    }
    
}