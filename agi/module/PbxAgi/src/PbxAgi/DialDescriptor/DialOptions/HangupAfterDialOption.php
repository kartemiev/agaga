<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\DialOptions\HangupAfterDialOptionInterface;
use PbxAgi\DialDescriptor\AbstractDialOptionParametrized;

class HangupAfterDialOption extends AbstractDialOptionParametrized implements HangupAfterDialOptionInterface
{
    protected $timeout;
    
    const IDENTIFIER = 'S';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
    protected function getValue()
    {
        return $this->timeout;
    }
	public function getTimeout()
    {
        return $this->timeout;
    }

	public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }    
     
}