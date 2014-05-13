<?php
namespace Vpbxui\Ivr\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Ivr  implements InputFilterAwareInterface
{
    public $id;
    public $custname;
    public $custdesc;    
    
    protected $inputFilter;                       // <-- Add this variable
     
   
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    public function exchangeArray($data)
    {
    	$this->id     = (isset($data['id'])) ? $data['id'] : null;
    	$this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
    	$this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;     
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
    				'name'     => 'id',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'Int'),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'custname',
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
    										'messages'=>
    										array(
    												\Zend\Validator\StringLength::TOO_SHORT => 'Неверная длина поля ввода',
    												\Zend\Validator\StringLength::TOO_LONG => 'Неверная длина поля ввода',
    												\Zend\Validator\StringLength::INVALID => 'Неверные символы в поле ввода',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'Поле не может быть пустым".',
    										),
    								),
    						),
    				),
    		)));
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'custdesc',
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
    										'messages' =>
    										array(
    												\Zend\Validator\StringLength::TOO_SHORT => 'Неверная длина поля ввода',
    												\Zend\Validator\StringLength::TOO_LONG => 'Неверная длина поля ввода',
    												\Zend\Validator\StringLength::INVALID => 'Неверные символы в поле ввода',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'Поле не может быть пустым".',
    										),
    								),
    						),
    				),
    		)));
    		$this->inputFilter = $inputFilter;
    		
    	}
    	return $this->inputFilter;
    }
 }