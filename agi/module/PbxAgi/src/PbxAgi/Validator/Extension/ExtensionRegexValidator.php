<?php
namespace PbxAgi\Validator\Extension;

use Zend\Validator\AbstractValidator;
use PbxAgi\Validator\Extension\ExtensionRegexValidatorInterface;

class ExtensionRegexValidator extends AbstractValidator implements ExtensionRegexValidatorInterface
{

    public function isValid($value)
    {
        $this->abstractOptions['messages'] = array();
        
        if (0==preg_match('/^\d{3}$/', $value)) {
            $this->abstractOptions['messages'][] = 'Extension is not valid';
            $result = false;
        }
        else 
        {
        	$result = true;
        }
        return $result;
    }
}