<?php
namespace PbxAgi\Service\DialString;

class SimpleTimeParser
{
    public $dateTime;
    public function __construct(\DateTime $dateTime)
    {
    	$this->dateTime = $dateTime;
    }
	public function __invoke($value)	
	{
	     	    
	    if ((0==preg_match('/^(2[0-3]{1}|[0-1][0-9]{1})([0-5]{1}?[0-9]{1})$/', $value, $parsed)) && (count(3==$parsed))) {	        
	    	$result = false;
	    }
	    else
	    {
	    	$result = $this->dateTime;
	    	$result->setTime((int)$parsed[1], (int)$parsed[2]);
	    }
	    return $result;
	}
}