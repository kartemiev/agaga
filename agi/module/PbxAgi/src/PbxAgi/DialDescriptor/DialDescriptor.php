<?php
namespace PbxAgi\DialDescriptor;

use PbxAgi\DialDescriptor\DialOptionInterface;
use PbxAgi\DialDescriptor\DialDescriptorInterface;

class DialDescriptor implements DialDescriptorInterface
{
    public $typeIdentifier;
    public $timeout;
    public $options;
    public $url;
    
    public function __construct(DialOptionInterface $options)
    {
        $this->options = $options;
    }
    
    public function assemble()
    {        
        if (!$this->typeIdentifier)
        {
          throw new \Exception('TypeIdentifier is not defined!');
        }        
        $getFields = function($obj) { return get_object_vars($obj); };
        $values = array_values($getFields($this));        
        foreach ($values as $key => $value)
        {
            if ( NULL == $value )
            {
                $values[$key]='';
            }
        }
        return implode(',', $values);        
    }
    
	public function getTypeIdentifier()
    {
        return $this->typeIdentifier;
    }

	public function getTimeout()
    {
        return $this->timeout;
    }

	public function getOptions()
    {
        return $this->options;
    }

	public function getUrl()
    {
        return $this->url;
    }

	public function setTypeIdentifier($typeIdentifier)
    {
        $this->typeIdentifier = $typeIdentifier;
    }

	public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

	public function setUrl($url)
    {
        $this->url = $url;
    }

}