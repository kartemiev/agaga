<?php
namespace PbxAgi\EntityResolver;

class ResolveResult
{
    protected $object;
    protected $resultvalue;
    protected $nextElementChildName;
    protected $next;
     public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }
    public function getObject()
    {
        return $this->object;
    }
    public function setResultvalue($resultvalue)
    {
        $this->resultvalue = $resultvalue;
        return $this;
    }    
    public function setNext($next = null)
    {
        $this->next = $next;
        return $this;
    }
    public function getNext()
    {
        return $this->next;
    }    
    public function getResultvalue()
    {
        return $this->resultvalue;        
    }
}