<?php
namespace PbxAgiTest\Service\RouteBuilderTest;
use \PbxAgiTest\Bootstrap;
use PbxAgi\Service\RouteBuilder\RouteBuilderFactory;
use PHPUnit_Framework_TestCase;
use PbxAgi\Trunk\Model\Trunk;
use PbxAgi\Route\Model\Route;
use Zend\Db\ResultSet\ResultSet;
use PbxAgi\TrunkDestination\Model\TrunkDestination;


class RouteBuilderTest extends PHPUnit_Framework_TestCase
{
	protected $routeBuilder;
	protected $mockedRouteTable;
	protected $mockedRouteValidator;
	protected $mockedTrunkDestinationTable;
	protected $mockedDestinationValidator;
	protected $mockedTrunkTable;
    public function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();         
        $serviceManager->setAllowOverride(true);         

        $this->mockedRouteTable =  $this->getMockBuilder('PbxAgi\Route\Model\RouteTable')
                                        ->disableOriginalConstructor()
                                        ->getMock();
        
        
         
        $serviceManager->setService('PbxAgi\Route\Model\RouteTable', $this->mockedRouteTable);
        
        

        $this->mockedRouteValidator =  $this->getMockBuilder('PbxAgi\Service\RouteBuilder\RouteValidator')
                                            ->disableOriginalConstructor()
                                            ->getMock();

        $serviceManager->setService('PbxAgi\Service\RouteBuilder\RouteValidator', $this->mockedRouteValidator);
        
        
        $this->mockedTrunkDestinationTable =  $this->getMockBuilder('PbxAgi\TrunkDestination\Model\TrunkDestinationTable')
                                                    ->disableOriginalConstructor()
                                                    ->getMock();
        
        $serviceManager->setService('PbxAgi\TrunkDestination\Model\TrunkDestinationTable', $this->mockedTrunkDestinationTable);
        

        $this->mockedDestinationValidator =  $this->getMockBuilder('PbxAgi\Service\RouteBuilder\DestinationValidator')
                                                  ->disableOriginalConstructor()
                                                  ->getMock();
        
        $serviceManager->setService('PbxAgi\Service\RouteBuilder\DestinationValidator', $this->mockedDestinationValidator);
        

        $this->mockedTrunkTable =  $this->getMockBuilder('PbxAgi\Trunk\Model\TrunkTable')
                                        ->disableOriginalConstructor()
                                        ->getMock();
        
        $serviceManager->setService('PbxAgi\Trunk\Model\TrunkTable', $this->mockedTrunkTable);
        
        
        $factory = new RouteBuilderFactory();
        
        $this->routeBuilder = $factory->createService($serviceManager);        
    }
    public function testRouteBuilderReturnsResolvedDestinations()
    {

        $route = new Route();
        
        $data = array(
            'id'=>10,
            'custname'=>'testname',
            'custdesc'=>'custdesc',
            'destinations'=>1,
            'isdefault'=>true
        );
        $route->exchangeArray($data);

        $this->mockedRouteValidator->expects($this->atLeastOnce())
                                ->method('validate')
                                ->with(10)
                                ->will($this->returnValue(true));

         
        $trunkdestination  = new TrunkDestination();
        $data = array(
            'routeref'=>10,
            'trunkref'=>197,
            'numbermatchref'=>12         	
        );
        $trunkdestination->exchangeArray($data);
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new TrunkDestination());
        $resultSet->initialize(array($trunkdestination));
        
         $this->mockedTrunkDestinationTable->expects($this->once())
                                           ->method('fetchAll')
                                           ->with(array('routeref'=>10))
                                           ->will($this->returnValue($resultSet));

         $this->mockedDestinationValidator->expects($this->once())
                                          ->method('validate')
                                          ->with(12)
                                          ->will($this->returnValue(true));
         
        $trunk = new Trunk();
        $data = array(
            'id'=>197,
            'secret'=>'mybigdurtysecret',
            'custname'=>'Super Provider',
            'custdesc'=>'',
            'name'=>'mymaintrunk',
            'defaultuser'=>'00001',
            'callbackextension'=>'00001',
            'callerid'=>'nope'
        );
         $trunk->exchangeArray($data);
         $this->mockedTrunkTable->expects($this->atLeastOnce())
                                ->method('getTrunk')
                                ->with(197)
                                ->will($this->returnValue($trunk));
          
         
        $routeBuilder = $this->routeBuilder;
    	$routeBuilder->setId(10);
    	$routeBuilder->setNumber('79251999108');
    	$routeBuilder->create();
    	$trunk = new Trunk();
		
		$trunk->exchangeArray($data);
		$trunks = array($trunk);
    	$destinations = $this->routeBuilder->getDestinations();
    	$this->assertEquals($destinations, $trunks);    	
    }
    public function testRouteBuilderThrowsAnExceptionWhenTrunkReferenceIsBroken()
    {
    
    	$route = new Route();
    
    	$data = array(
    			'id'=>10,
    			'custname'=>'testname',
    			'custdesc'=>'custdesc',
    			'destinations'=>1,
    			'isdefault'=>true
    	);
    	$route->exchangeArray($data);
    
    	$this->mockedRouteValidator->expects($this->atLeastOnce())
    	->method('validate')
    	->with(10)
    	->will($this->returnValue(true));
    
    	 
    	$trunkdestination  = new TrunkDestination();
    	$data = array(
    			'routeref'=>10,
    			'trunkref'=>197,
    			'numbermatchref'=>12
    	);
    	$trunkdestination->exchangeArray($data);
    	$resultSet = new ResultSet();
    	$resultSet->setArrayObjectPrototype(new TrunkDestination());
    	$resultSet->initialize(array($trunkdestination));
    
    	$this->mockedTrunkDestinationTable->expects($this->once())
    	->method('fetchAll')
    	->with(array('routeref'=>10))
    	->will($this->returnValue($resultSet));
    
    	$this->mockedDestinationValidator->expects($this->once())
    	->method('validate')
    	->with(12)
    	->will($this->returnValue(true));
    	 
    	$trunk = new Trunk();
    	$data = array(
    			'id'=>197,
    			'secret'=>'mybigdurtysecret',
    			'custname'=>'Super Provider',
    			'custdesc'=>'',
    			'name'=>'mymaintrunk',
    			'defaultuser'=>'00001',
    			'callbackextension'=>'00001',
    			'callerid'=>'nope'
    	);
    	$trunk->exchangeArray($data);
    	$this->mockedTrunkTable->expects($this->atLeastOnce())
    	->method('getTrunk')
    	->with(197)
    	->will($this->returnValue(null));
    
    	 
    	$routeBuilder = $this->routeBuilder;
    	$routeBuilder->setId(10);
    	$routeBuilder->setNumber('79251999108');
    	
    	try
    	{
    		$routeBuilder->create();
    	}
    	catch (\Exception $e)
    	{
    		$this->assertSame('Trunk reference broken', $e->getMessage());
    		return;
    	}
    	 
    	$this->fail('Expected exception was not thrown');
    	
    }
    
    public function testRouteBuilderThrowsAnExceptionWhenNoneDestinationPresent()
    {

        $route = new Route();
        
        $data = array(
        		'id'=>10,
        		'custname'=>'testname',
        		'custdesc'=>'custdesc',
        		'destinations'=>1,
        		'isdefault'=>true
        );
        $route->exchangeArray($data);
        
        $this->mockedRouteValidator->expects($this->atLeastOnce())
        ->method('validate')
        ->with(10)
        ->will($this->returnValue(true));
        
         
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new TrunkDestination());
        $resultSet->initialize(array());
        
        $this->mockedTrunkDestinationTable->expects($this->once())
        ->method('fetchAll')
        ->with(array('routeref'=>10))
        ->will($this->returnValue($resultSet));
        
         
        $trunk = new Trunk();
        $data = array(
        		'id'=>197,
        		'secret'=>'mybigdurtysecret',
        		'custname'=>'Super Provider',
        		'custdesc'=>'',
        		'name'=>'mymaintrunk',
        		'defaultuser'=>'00001',
        		'callbackextension'=>'00001',
        		'callerid'=>'nope'
        );
         
         
        $routeBuilder = $this->routeBuilder;
        $routeBuilder->setId(10);
        $routeBuilder->setNumber('79251999108');

        
        try
        {
            $routeBuilder->create();            
        }
        catch (\Exception $e)
        {
        	$this->assertSame('Not a single destination defined for this route', $e->getMessage());
        	return;
        }
         
        $this->fail('Expected exception was not thrown');
        
             	
    }
    
    public function testOptionsCanBeSetCorrectly()
    {
    	$routeBuilder = $this->routeBuilder;
    	$routeBuilder->setOptions(
			array(
			    'id'=>10,
			    'number'=>'6408040',
			    'num_type'=>'regular'
    	          )
    	);
    	$this->assertSame(10, $routeBuilder->getId(), 'id should be same as set up');
    	$this->assertSame('6408040', $routeBuilder->getNumber(), 'number should be same as set up');
    	 
    }
    
}