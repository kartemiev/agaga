<?php

namespace PbxAgi\EntityResolver\Element;

use PbxAgi\EntityResolver\Element\AbstractElement;
use PbxAgi\EntityResolver\ResolveResult;
 
class OneToManyElement extends AbstractElement
{
	
	protected $resultfield;
	public function resolve($primarykey)
	{
		$result = parent::resolve($primarykey);		
		$result->setResultvalue($result->getObject()->{$this->resultfield});
		if ($this->children)
		{
			$values = array_values($this->children);
			$value = array_shift($values);
			$result->setNext($value);		
		}
		else 
		{
		    $result->setNext();
		}
		return $result;
	}
	public function setResultField($resultfield)
	{
	    $this->resultfield = $resultfield;
	}
}
