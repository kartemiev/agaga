<?php

namespace PbxAgi\EntityResolver\Element;

use Zend\Filter\Word\UnderscoreToCamelCase;
use PbxAgi\EntityResolver\Element\MethodNotExistsException;
use PbxAgi\EntityResolver\Element\RecordNotFoundException;
use PbxAgi\EntityResolver\ResolveResult;

abstract class AbstractElement
{
	protected $table;
 	protected $children;
	protected $primaryfield;
	protected $name;
	protected $branchname;
 
	public function resolve($primarykey)
	{
		$filter = array($this->getPrimaryfield() => $primarykey);
 		$resultset = $this->table->fetchAll($filter, 1);
 		$object = $resultset->current();
 			
 		if (!$object)
		{
			throw new RecordNotFoundException('record with '.$primarykey.' not found');
		}
		
		$result = new ResolveResult();
		$result->setObject($object);
		return $result;
	}
	
	public function get($name)
   	{
   	    return $this->{$name};
   	}
   	public function set($name, $value)
   	{
   		$filter = new UnderscoreToCamelCase();
   		$methodname = 'set'.$filter($name);
   		if (!method_exists($this,$methodname))
   		{
   		    throw new MethodNotExistsException();
   		}
   	    call_user_func(array($this,$methodname), $value);
   	}    
   	public function setTable($table)
   	{
   	    $this->table = $table;
   	} 
   	public function setPrimaryfield($primaryfield)
   	{
   	    $this->primaryfield = $primaryfield;
   	}
   	public function getPrimaryfield()
   	{
   		return $this->primaryfield;
   	}
   	public function addChild(AbstractElement $element)
   	{
   	    $this->children[] = $element;
   	    return $element;
   	}
   	public function getChildren()
   	{
   	    return $this->children;
   	}
   	public function setName($name)
   	{
   		$this->name = $name;
   	    return $this;
   	}
   	public function getName()
   	{
   	    return $this->name;
   	}
   	public function setBranchName($branchname)
   	{
   	    $this->branchname = $branchname;
   	    return $this;
   	}
   	public function getBranchName()
   	{
   	    return $this->branchname;
   	}
 }