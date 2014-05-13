<?php
namespace PbxAgi\Service\RouteBuilder;

use PbxAgi\Route\Model\RouteTable;
use PbxAgi\RegEntry\Model\RegEntryTable;
use PbxAgi\TrunkDestination\Model\TrunkDestinationTableInterface;
use PbxAgi\Trunk\Model\TrunkTableInterface;
 
class RouteBuilder
{
	protected $id;
	protected $number;
	protected $destinations = array();		
  	protected $trunkDestinationTable;
	protected $trunkTable;
	protected $destinationValidator;
	protected $routeValidator;	
 	
	protected $routes;
	
	public function __construct(
 			TrunkDestinationTableInterface $trunkDestinationTable,
			TrunkTableInterface $trunkTable,
			DestinationValidator $destinationValidator,
			RouteValidator $routeValidator			
			)
	{
 	    $this->trunkDestinationTable = $trunkDestinationTable;
	    $this->trunkTable = $trunkTable;
	    $this->destinationValidator = $destinationValidator;
	    $this->routeValidator = $routeValidator;
	}
    public function create($options = null)
    {
       $this->setOptions($options);
       if (!$this->routes)
       {
       	$this->routes = $this->assemble();
       }
       return $this->routes;
    }
    protected function assemble()
    {
    	$routeValidator = $this->routeValidator;
    	$id = ($routeValidator->validate($this->id))? $this->id : $routeValidator->getDefaultRoute();
       	
    	$trunkDestinations = $this->fetchTrunkDestinations($id);        

		$destinationValidator = $this->destinationValidator;
        $destinationValidator->setNumber($this->number);

 
        
        foreach ($trunkDestinations as $trunkdestination)
        {        	  
         	if ($destinationValidator->validate($trunkdestination->numbermatchref))
        	{
         		$this->addDestinationByTrunkId($trunkdestination->trunkref);
         	}
         }
     }
 
    protected function fetchTrunkDestinations($routeid)
    {
    	$trunkDestinationTable = $this->trunkDestinationTable;
    	$destinations = $trunkDestinationTable->fetchAll(
    			array('routeref' => $routeid)
    	);
    	if ($destinations->count()<1)
    	{
    		throw new \Exception('Not a single destination defined for this route');
    	}
    	return $destinations;
    }
    protected function addDestinationByTrunkId($trunkid)
    {
    	$trunk = $this->trunkTable->getTrunk($trunkid);
    	if (!$trunk)
    	{
    		throw new \Exception('Trunk reference broken');
    	}
    	$this->destinations[] = $trunk;    	 
    }
    public function setOptions($options = null)
    {    	
       if ($options)
       {
       	if (isset($options['id']))
       	{
       	    $this->id = $options['id'];
       	}
       	if (isset($options['number']))
       	{
       		$this->number = $options['number'];
       	}
       	if (isset($options['num_type']))
       	{
       		$this->numType = $options['num_type'];
       	}
       }
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getId()
    {
        return $this->id;        
    }    
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function getDestinations()
    {
        return $this->destinations;
    }
   
    
}