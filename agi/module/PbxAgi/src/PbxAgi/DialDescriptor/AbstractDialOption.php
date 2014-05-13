<?php
namespace PbxAgi\DialDescriptor;

use PbxAgi\DialDescriptor\DialOptionInterface;

abstract class AbstractDialOption implements DialOptionInterface
{
    public $isEnabled; 

    public function enable()
    {
        $this->isEnabled = true;
        return $this;
    }
    public function disable()
    {
        $this->isEnabled = false;
        return $this;
    }
    public function getStatus()
    {
        return $this->isEnabled;
    }
    
    abstract protected function getIdentifier();
    public function __toString()
    {
        return ($this->isEnabled)?$this->getIdentifier():'';
    }        
}