<?php
namespace PbxAgi\Validator\Time;
use Zend\Validator\AbstractValidator;

class SimpleTimeWithoutSemicolumnValidator extends AbstractValidator
{
	public function isValid($value)
	{
	    $this->abstractOptions['messages'] = array();
	    
	    if (0==preg_match('/^(2[0-3]{1}|[0-1][0-9]{1})([0-5]{1}?[0-9]{1})$/', $value)) {
	    	$this->abstractOptions['messages'][] = 'Time is not valid';
	    	$result = false;
	    }
	    else
	    {
	    	$result = true;
	    }
	    return $result;
	}
}