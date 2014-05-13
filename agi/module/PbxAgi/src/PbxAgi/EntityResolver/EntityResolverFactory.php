<?php

namespace PbxAgi\EntityResolver;

use PbxAgi\EntityResolver\InvalidElementTypeException;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\EntityResolver\EntityResolverFactoryInterface;
use PbxAgi\EntityResolver\Element\RootElement;

class EntityResolverFactory implements  EntityResolverFactoryInterface
{
	public $serviceLocator;
	public $elementaliases = array(
				'branchelement' => 'PbxAgi\EntityResolver\Element\BranchElement',
 				'onetomanyelement' => 'PbxAgi\EntityResolver\Element\OneToManyElement',
				'onetooneelement' => 'PbxAgi\EntityResolver\Element\OneToOneElement',
				'rootelement' => 'PbxAgi\EntityResolver\Element\RootElement'
			);
	public function __construct(ServiceLocatorInterface $serviceLocator)
	{
	    $this->serviceLocator = $serviceLocator;
	}
	public function create($element)
	{
		$elementChain = new RootElement();	/* starting create from root */	
	    $this->createChain($elementChain, $element);	 
	    return $elementChain;
	}
    public function createChain($elementChainPart, $element)

    {	
		$elementChainPart = $elementChainPart->addChild($this->createElement($element));
    	  	 
		if (isset($element['children']))
		{
			foreach ($element['children'] as $child)
			{			 
				$this->createChain($elementChainPart, $child);
			}
		}
    }
    protected function createElement($element)
    {
    	$type = $this->elementaliases[$element['type']];
    	if (!$type)
    	{
    		throw new InvalidElementTypeException('element type '.$element['type'].' is undefined');
    	}
    	$instance = new $type;
    	foreach ($element['options'] as $key=>$option)
    	{
    		if('table'==$key)
    		{
    		    $option = $this->serviceLocator->get($option);
    		}
    		$instance->set($key,$option);
    	}    	 
    	return $instance; 
    }
}