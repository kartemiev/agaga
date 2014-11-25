<?php
namespace Vpbxui\DefaultDenyPermit\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class DefaultDenyPermit  implements InputFilterAwareInterface
{
    public $deny;
    public $permit;    
    
    protected $inputFilter;   
     
   
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    public function exchangeArray($data)
    {
     	$this->deny     = (isset($data['deny'])) ? $data['deny'] : null;
    	$this->permit     = (isset($data['permit'])) ? $data['permit'] : null;     
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
    				'name'     => 'deny',
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
    										'min'      => 0,
    										'max'      => 512,
    										'messages'=>
    										array(
    												\Zend\Validator\StringLength::TOO_SHORT => 'Неверная длина поля ввода',
    												\Zend\Validator\StringLength::TOO_LONG => 'Неверная длина поля ввода',
    												\Zend\Validator\StringLength::INVALID => 'Неверные символы в поле ввода',
    										)
    								),
    						),
    				 
    				),
    		)));
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'permit',
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
    										'min'      => 0,
    										'max'      => 512,
    										'messages' =>
    										array(
    												\Zend\Validator\StringLength::TOO_SHORT => 'Неверная длина поля ввода',
    												\Zend\Validator\StringLength::TOO_LONG => 'Неверная длина поля ввода',
    												\Zend\Validator\StringLength::INVALID => 'Неверные символы в поле ввода',
    										)
    								),
    						),
    				 
    				),
    		)));
    		$this->inputFilter = $inputFilter;
    		
    	}
    	return $this->inputFilter;
    }
 }