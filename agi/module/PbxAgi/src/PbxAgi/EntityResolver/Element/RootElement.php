<?php

namespace PbxAgi\EntityResolver\Element;

use PbxAgi\EntityResolver\Element\AbstractElement;
use PbxAgi\EntityResolver\ResolveResult;
use PbxAgi\EntityResolver\Element\ElementException; 
class RootElement extends AbstractElement
{
    public function resolve($primarykey)
    {
    	$children  = $this->getChildren();
    	$values = array_values($children);
    	$firstvalue = array_shift($values);
     	$result = new ResolveResult();
    	$result->setNext($firstvalue);
    	$result->setResultvalue($primarykey);    	    	 
    						/*
							root element can only have single descedant
							*/
    	return $result;
    }
}