<?php
namespace PbxAgi\Service\RouteBuilder;

use PbxAgi\TrunkDestination\Model\TrunkDestination;
use PbxAgi\RegEntry\Model\RegEntryTableInterface;
use PbxAgi\Route\Model\RouteTable;

class RouteValidator
{ 
	protected $routeTable;
	protected $defaultRoute;
 	public function __construct(RouteTable $routeTable)
	{
	    $this->routeTable = $routeTable;
	}
    public function validate($routeid)
    {
    	$routeTable = $this->routeTable;
    	if ($routeid){
    		$route = $routeTable->getRoute($routeid);
    	}
    	if (!isset($route))
    	{
    	 
    		$defaultroutes = $routeTable->fetchAll(array('isdefault'=>true));
    		if ($defaultroutes->count()>0)
    		{
    			$this->defaultRoute = $defaultroutes->current()->id;
     		}
    		else
    		{
    			throw new \Exception('Neither route not found nor default route defined!');
    		}
    	}
    	$route = (isset($route))?$route:null;
    	return $route;
    }
    public function getDefaultRoute()
    {
        return $this->defaultRoute;
    }
   
}