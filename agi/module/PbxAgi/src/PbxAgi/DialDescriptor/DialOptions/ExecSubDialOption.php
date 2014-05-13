<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrized;
use PbxAgi\DialDescriptor\DialOptions\ExecSubDialOptionInterface;
 
class ExecSubDialOption extends AbstractDialOptionParametrized implements ExecSubDialOptionInterface
{
    protected $subName;
    
    const IDENTIFIER = 'U';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
    protected function getValue()
    {
        return $this->subName;
    }
	public function getSubName()
    {
        return $this->subName;
    }

	public function setSubName($subName)
    {
        $this->subName = $subName;
    }    
    
}