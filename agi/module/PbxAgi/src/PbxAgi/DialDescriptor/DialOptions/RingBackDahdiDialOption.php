<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrizedOptional;
use PbxAgi\DialDescriptor\DialOptions\RingBackDahdiDialOptionInterface;
 
class RingBackDahdiDialOption extends AbstractDialOptionParametrizedOptional 
implements RingBackDahdiDialOptionInterface
{
    protected $mode;
    
    const IDENTIFIER = 'O';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
    protected function getValue()
    {
        return $this->mode;
    }
    
    
	public function getMode()
    {
        return $this->mode;
    }

	public function setMode($mode)
    {
        $this->mode = $mode;
    }

    
}