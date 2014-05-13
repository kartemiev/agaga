<?php
namespace PbxAgi\DialDescriptor;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrized;

abstract class AbstractDialOptionsParametrizedContextExtension extends AbstractDialOptionParametrized
{
    protected  $context;
    protected  $extension;
    protected  $priority;
    
     
    public function getValue()
    {
        $values = get_object_vars($this);
        $valuesFiltered = array_values(array_intersect_key($values, array_flip(array('context','extension','priority'))));
        if (in_array(NULL, $valuesFiltered, true))
        {
            throw new \Exception('One of values not defined');
        }
         return implode('^', $valuesFiltered);
    }

    public function getContext()
    {
        return $this->context;
    }
    
    public function getExtension()
    {
        return $this->extension;
    }
    
    public function getPriority()
    {
        return $this->priority;
    }
    
    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }
    
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }
    
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
}