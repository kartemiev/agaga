<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrized;
use PbxAgi\DialDescriptor\DialOptions\AnnouncementDialOptionInterface;
 
class AnnouncementDialOption extends AbstractDialOptionParametrized implements AnnouncementDialOptionInterface
{
    const IDENTIFIER = 'A';
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
    protected $filename;
	/**
     * @return the $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

	/**
     * @param field_type $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    protected function getValue()
    {
        return $this->getFilename();
    }
    
}