<?php

namespace PbxAgi\EntityResolver\Element;

use PbxAgi\EntityResolver\Element\AbstractElement;
use PbxAgi\EntityResolver\ResolveResult;
 
class OneToOneElement extends AbstractElement
{
	public function resolve($parentkey)
	{		
		$result = parent::resolve($parentkey);		
		$result->setResultvalue($result->getObject()->id);
		if ($this->children){
			$result->setNext(array_shift(array_values($this->children)));
		} else 
		{
		    $result->setNext();
		}
		return $result;
	}
}
