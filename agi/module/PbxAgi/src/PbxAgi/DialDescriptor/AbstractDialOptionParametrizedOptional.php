<?php
namespace PbxAgi\DialDescriptor;

use PbxAgi\DialDescriptor\AbstractDialOption;
 
abstract class AbstractDialOptionParametrizedOptional extends AbstractDialOption  
{

    public function __toString()
    {
        if ($this->isEnabled) {
            $identifier = parent::__toString();
            $value = $this->getValue();
            $result = (isset($value))?"{$identifier}({$value})":$identifier;
            return $result;
        } else         	
        {
        	return '';
        } 	
    }
    /**
     * @return the $value
     */
    abstract protected function getValue();

}