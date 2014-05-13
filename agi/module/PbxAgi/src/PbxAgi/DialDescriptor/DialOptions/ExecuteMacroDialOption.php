<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrized;
use PbxAgi\DialDescriptor\DialOptions\ExecuteMacroDialOptionInterface;
 
class ExecuteMacroDialOption extends AbstractDialOptionParametrized implements ExecuteMacroDialOptionInterface
{
    protected $macroName;
    
    const IDENTIFIER = 'M';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
    protected function getValue()
    {
        return $this->macroName;
    }
    
	public function getMacroName()
    {
        return $this->macroName;
    }

	public function setMacroName($macroName)
    {
        $this->macroName = $macroName;
    }

    
}