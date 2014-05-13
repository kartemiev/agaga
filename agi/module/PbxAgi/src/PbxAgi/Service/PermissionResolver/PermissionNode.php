<?php
namespace PbxAgi\Service\PermissionResolver;

use PbxAgi\Service\PermissionResolver\Result;

class PermissionNode
{
	protected $table;
	protected $method;
	protected $parentIdFieldName;
 	protected $parent;
 	protected $idFieldValue;
	
	public function fetch($id, $permissionName)
	{
		$method = $this->method;
		$id = ($this->idFieldValue)?$this->idFieldValue:$id;
		 	
	    $row = $this->table->$method($id);
 	    if($row)
	    {
	    	$result = new Result();
	        $result->value = $row->$permissionName;
	        if (isset($this->parentIdFieldName))
	        {
	        	$parentFieldName = $this->parentIdFieldName;
	        	$result->id = $row->$parentFieldName;	        	
	        }
  	    }
 	    $result = (isset($result))?$result:null;
 	    return $result;
	}
	public function setParentIdFieldName($parentIdFieldName)
	{
	    $this->parentIdFieldName = $parentIdFieldName;
	}
	public function setTable($table)
	{
	    $this->table = $table;
	}
	public function setMethod($method)
	{
	    $this->method = $method;
	}
	
	public function add($parent)
	{
	    $this->parent = $parent;
	    return $this;
	}
	public function getParent()
	{
	    return $this->parent;
	}
	 
	public function setIdFieldValue($idFieldValue)
	{
	    $this->idFieldValue = $idFieldValue;
	    return $this;
	}
	public function getIdFieldValue()
	{
	    return $this->idFieldValue;
	}	
}