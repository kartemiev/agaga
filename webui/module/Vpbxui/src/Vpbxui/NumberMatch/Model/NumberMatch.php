<?php
namespace Vpbxui\NumberMatch\Model;


use Zend\InputFilter\Factory as InputFactory;   
use Zend\InputFilter\InputFilter;                
use Zend\InputFilter\InputFilterAwareInterface;    
use Zend\InputFilter\InputFilterInterface;   
use Zend\Validator\InArray;
use Zend\Db\Adapter\AdapterInterface;

class NumberMatch implements InputFilterAwareInterface
{
    public $id;
    public $custname;
    public $regentries;
    public $custdesc;
       
     protected $inputFilter;                      
        
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->regentries     = (isset($data['regentries'])) ? $data['regentries'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;        
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
     				'name'     => 'id',
     				'required' => true,
     				'filters'  => array(
     						array('name' => 'Int'),
     				),
     		)));

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
     										'max'      => 50,
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
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'regentries',
     				'required' => false
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
     										'max'      => 250,
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
