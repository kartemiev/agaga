<?php

namespace PbxAgi\EntityResolver\Element;

use PbxAgi\EntityResolver\Element\AbstractElement;
use PbxAgi\EntityResolver\Element\BranchChoiceNotFoundException;
use PbxAgi\EntityResolver\Element\BranchValueIsEmptyOrUndefined; 

class BranchElement extends AbstractElement
{
	protected $branchfield;
	protected $resultfields;
	 
	public function resolve($primarykey)
	{
		$result = parent::resolve($primarykey);
		
		$resultobject = $result->getObject();
		$branchfield = $this->branchfield;
		$branchfieldChoice = $resultobject->$branchfield;
		$branchValueColumnName = $this->resultfields[$branchfieldChoice];
		$branchvalue = $resultobject->$branchValueColumnName;
		 		
 		if (!$branchvalue)
 		{
 		    throw new BranchValueIsEmptyOrUndefined();
 		}
 		
  		foreach ($this->getChildren() as $child)
		{
		    if ($branchfieldChoice==$child->getBranchname())
		    {
		    	$next = $child;
		    	$result->setResultvalue($branchvalue);		    	 
		        break;
		    }
		}
		if ($next)
		{
			$result->setNext($child);
		} 
		else
		{
		    throw new BranchChoiceNotFoundException();
		}
		return $result;
	}
	public function setBranchfield($branchfield)
	{
	    $this->branchfield = $branchfield;
	}
	public function setResultFields($resultfields)
	{
		$this->resultfields = $resultfields;
	}
}
