<?php
namespace Vpbxui\ExtensionGroup\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;
use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTableInterface;

class ExtensionGroupProfilePicker implements InputFilterAwareInterface
{
    public $profile;
    
    protected $inputFilter;                       // <-- Add this variable
    
    protected $extensionGroupProfileTable;
  
    public function __construct(ExtensionGroupProfileTableInterface $extensionGroupProfileTable)
    {
        $this->extensionGroupProfileTable = $extensionGroupProfileTable;
    }
    
    public function exchangeArray($data)
    {
        $this->profile     = (isset($data['profile'])) ? $data['profile'] : null;
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

      public function setInputFilter(InputFilterInterface $inputFilter)
     {
     	throw new \Exception("Not used");
     }
     
     public function getInputFilter()
     {          
      	if (!$this->inputFilter) {
      	    
       	    
     		$inputFilter = new InputFilter();
     		$factory     = new InputFactory();
            
     		$profileOptions = $this->getGroupProfileOptions();
  
     		
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'profile',
     				'required' => true,     		
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
                                        'haystack' => $profileOptions,
                                        'strict'   => InArray::COMPARE_STRICT, 
     								    'messages' => array(
     								        \Zend\Validator\InArray::NOT_IN_ARRAY => 'задано неверное значение',
     								    ),
              								),
     						),     				    
     				),
     		)));
 
     		 
     		$this->inputFilter = $inputFilter;
     	}
     
     	return $this->inputFilter;
     }
     protected function getGroupProfileOptions()
     {
         $extensionGroupProfileTable = $this->extensionGroupProfileTable;
         $extensionGroupProfiles = $extensionGroupProfileTable->fetchAll();
         $profiles = array();
         foreach ($extensionGroupProfiles as $extensionGroupProfile)
         {
             $profiles[] = (string)$extensionGroupProfile->id;             
         }
          return $profiles;
     }
     
 }
