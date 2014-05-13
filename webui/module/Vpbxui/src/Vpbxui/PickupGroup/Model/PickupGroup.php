<?php
namespace Vpbxui\PickupGroup\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
 
class PickupGroup implements InputFilterAwareInterface
{
    public $name;
    public $custname;
    public $description;
    
    protected $inputFilter;                       // <-- Add this variable
    
    public function exchangeArray($data)
    {
        $this->name     = (isset($data['name'])) ? $data['name'] : null;      
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->description     = (isset($data['description'])) ? $data['description'] : null;
        
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
     
                    
                        		
                        		
                      $inputFilter->add($factory->createInput(array(
                        		    'name'     => 'custname',
                        		    'required' => true,
                        		    'filters'  => array(
                        		        array('name' => 'StripTags'),
                        		        array('name' => 'StringTrim'),
                        		    ),
                        		    'validators' => array(
                        		        array(
                        		            'name'    => 'StringLength',
                        		            'options' => array(
                        		                'encoding' => 'UTF-8',
                        		                'min'      => 1,
                        		                'max'      => 100,
                        		            ),
                        		        ),
                        		    ))));

                      $inputFilter->add($factory->createInput(array(
                          'name'     => 'description',
                          'required' => false,
                          'filters'  => array(
                              array('name' => 'StripTags'),
                              array('name' => 'StringTrim'),
                          ),
                          'validators' => array(
                              array(
                                  'name'    => 'StringLength',
                                  'options' => array(
                                      'encoding' => 'UTF-8',
                                      'min'      => 1,
                                      'max'      => 100,
                                  ),
                              ),
                          ))));
     		$this->inputFilter = $inputFilter;
     	}
     
     	return $this->inputFilter;
     }
}
