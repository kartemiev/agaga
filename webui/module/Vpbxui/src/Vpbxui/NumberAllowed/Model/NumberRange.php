<?php
namespace Vpbxui\NumberAllowed\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;

class NumberRange implements InputFilterAwareInterface
{
    public $id;
	public $value;
	protected $inputFilter;     
	
   public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;            
        $this->value     = (isset($data['value'])) ? $data['value'] : null;
        
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
            		'name'     => 'chk_group',
            		'required' => true,
            /*		'validators' => array(
            				array(
            						'name'    => 'InArray',
            						'options' => array(
            								'haystack' => array('100', '200','300','400','500','600','700','900'),
            								'strict'   => InArray::COMPARE_STRICT
            						),
            						'messages' => array(
            							InArray::NOT_IN_ARRAY => 'неверное значение".',
            						),
            				),
            		),*/
            )));
            
/*
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'id',            	 
            		'required' => false,
            )));
  */          
            
          		$this->inputFilter = $inputFilter;
        }
         
        return $this->inputFilter;
    }
}