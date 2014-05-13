<?php
namespace PbxAgi\DialDescriptor;

use PbxAgi\DialDescriptor\AbstractDialOption;

abstract class AbstractDialOptionParametrized extends AbstractDialOption
{
    
   public function __toString()
   {
       if ($this->isEnabled) {
        $identifier = parent::__toString();
        $value = $this->getValue();
        if (!$value)
        {
            throw new \Exception("Value not set");
        }
        $result = "{$identifier}({$value})";
        return $result;
       }
       else
       {
       	 return '';
       }
   }
/**
     * @return the $value
     */
    abstract protected function getValue();

}