<?php
namespace PbxAgi\Extension\Model;

use Zend\Validator\AbstractValidator;
use PbxAgi\Extension\Model\ExtensionTableInterface;
use PbxAgi\Extension\Model\ExtensionValidatorInterface;


class ExtensionValidator extends AbstractValidator implements ExtensionValidatorInterface {
    protected $extensionTable;
    public function __construct(ExtensionTableInterface $extensionTable)
    { 
        $this->extensionTable = $extensionTable;    
    }
    public function isValid($value) {
        return $this->extensionTable->isValid($value);
    }   
    
}
