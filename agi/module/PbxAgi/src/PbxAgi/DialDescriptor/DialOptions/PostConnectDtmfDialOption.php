<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrized;
 
class PostConnectDtmfDialOption extends AbstractDialOptionParametrized
{
    const IDENTIFIER = 'D';
    protected $digits;
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
	/**
     * @return the $digits
     */
    protected function getValue()
    {
        return $this->getDigits();
    }
    public function getDigits()
    {
        return $this->digits;
    }

	/**
     * @param field_type $digits
     */
    public function setDigits($digits)
    {
        $this->digits = $digits;
    }
    
    
}