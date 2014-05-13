<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrizedOptional;
use PbxAgi\DialDescriptor\DialOptions\PrivacyManagerDialOptionInterface;
 
class PrivacyManagerDialOption extends AbstractDialOptionParametrizedOptional
implements PrivacyManagerDialOptionInterface
{
    protected $database;
    
    const IDENTIFIER = 'P';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
    protected function getValue()
    {
        return $this->database;
    }
	public function getDatabase()
    {
        return $this->database;
    }

	public function setDatabase($database)
    {
        $this->database = $database;
    }    
    
}