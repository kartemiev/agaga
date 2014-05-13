<?php
namespace PbxAgi\EntityResolver;

use PbxAgi\EntityResolver\ResolveResult;
use PbxAgi\EntityResolver\EntityResolverInterface;
use PbxAgi\EntityResolver\Element\RootElement;

class AbstractEntityResolver implements EntityResolverInterface
{
	protected $options;
	protected $elementChain;
	protected $searchResult;	
    public function __construct($options  = null)
    {
        if ($options)
        {
            $this->options = $options;
        }
    }
    
    public function resolve(ResolveResult $resolveresult = null)
    {    
		
    	if (!$resolveresult)
    	{
    	    $next  = $this->elementChain;
    	    $parent = $this->getInitialValue();
    	}
    	else 
    	{
    	    $parent = $resolveresult->getResultvalue();
    	    $next = $resolveresult->getNext();
    	}
        $result = $next->resolve($parent);
        $next = $result->getNext();
         if (!$next)
        {        	 
            $this->searchResult = $result->getObject();
            return $this;
        } 
     
        $this->resolve($result);
    }
    
    public function setOptions($options)
    {
        $this->options = $options;
    }
    public function getOptions()
    {
        return $this->options;
    }    
    public function setElementChain($elementChain)
    {
        $this->elementChain = $elementChain;
        return $this;
    }
    public function getElementChain()
    {
        return $this->elementChain;
    }
    public function setInitialValue($value)
    {
        $this->options['parentvalue'] = $value;
    }
    public function getInitialValue()
    {
        return $this->options['parentvalue'];
    }
    
    public function getSearchResult()
    {
        return $this->searchResult;
    }
}