<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrizedOptional;
use PbxAgi\DialDescriptor\DialOptions\RingingMohDialOptionDialOptionInterface; 

class RingingMohDialOption extends AbstractDialOptionParametrizedOptional  
{
   protected $mohClass;
   
   const IDENTIFIER = 'm';
   protected function getIdentifier()
   {
       return self::IDENTIFIER;
   }
   
   protected function getValue()
   {
       return $this->mohClass;
   }
   
    public function getMohClass()
    {
        return $this->mohClass;
    }

    public function setMohClass($mohClass)
    {
        $this->mohClass = $mohClass;
    }       
}