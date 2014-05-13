<?php
namespace PbxAgi\Service\PermissionResolver;

use PbxAgi\Service\PermissionResolver\PermissionNode;
use Zend\Stdlib\Hydrator\ClassMethods as Hydrator;
 use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionNodeFactory
{
	protected $serviceLocator;
	public function __construct(ServiceLocatorInterface $serviceLocator)
	{
	    $this->serviceLocator = $serviceLocator;
	}
    public function create($options)
    {
    	$node = new PermissionNode();    	
    	$hydrator = new Hydrator(false);    	
    	if (isset($options['table']))
    	{
    		$options['table'] = $this->serviceLocator->get($options['table']);
    	}    	 
    	$hydrator->hydrate($options, $node);    
    	return $node;	        
    }
     
}