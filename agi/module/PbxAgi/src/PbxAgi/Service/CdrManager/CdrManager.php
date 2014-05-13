<?php
namespace PbxAgi\Service\CdrManager;

use PbxAgi\Service\ClientImpl\ClientImplInterface;
use Zend\Filter\Word\CamelCaseToUnderscore;

class CdrManager
{
    protected $agi;
    public function __construct(ClientImplInterface $agi)
    {
        $this->agi = $agi;
    }   
    
    public function __call($method, $values)
    {
        $v = $values;
        $value = array_shift(array_values($v));
         if ('set' == substr($method,0,3))
        {
            $filter = new CamelCaseToUnderscore();
            $fieldName = strtolower(
                $filter->filter(substr($method, 3)
                    )
                );
            
            $this->agi->exec('Set',array("CDR({$fieldName})=\"{$value}\""));            
        }
        
    }    
}