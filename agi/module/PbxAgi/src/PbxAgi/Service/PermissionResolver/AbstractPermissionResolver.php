<?php
namespace PbxAgi\Service\PermissionResolver;

use PbxAgi\Extension\Model\Extension;

class AbstractPermissionResolver
{
	protected $root;
	protected $current;
	protected $fieldname;
	protected $result;
	protected $permissionName;
	public function __construct($root=null)
	{
	    $this->root = $root;
	}
    public function resolv($permissionName, Extension $extension)
    {
    	$this->result = null;
    	$this->permissionName = $permissionName;    
        $value = $this->doResolution($this->root, $extension->id);
        return $this->result;
    }
    protected function doResolution($node, $id)
    {
    	$result = $node->fetch($id, $this->permissionName);
         if($result)
        {
         	 
        	$value = $result->getValue();
        	$id = $result->getId();
        	$this->result = $result;        	 
         	if ('UNDEFINED'!== strtoupper($result->value))
        	{
            	return;
        	}        
        	$node = $node->getParent();        
         	if ($node)
        	{
        		$this->doResolution($node, $id);
        	}
          }               
    }
    public function setRoot($root)
    {
        $this->root = $root;
        return $this;
    }
    public function getRoot()
    {
        return $this->root;
    }
    public function add($node)
    {
        if (!$this->root)
        {
            $this->setRoot($node);
            $this->current = $node;
        }
        else 
        {
        	$current = $this->current;
            $current->add($node);
            $this->current = $node;
        }
    }
    public function getResult()
    {
        return $this->result;
    }
}