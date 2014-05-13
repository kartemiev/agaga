<?php
namespace Vpbxui\Offday\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;
use Zend\Db\Adapter\AdapterInterface;

class Offday implements InputFilterAwareInterface
{
    public $id;
    public $rdate;
    public $isworking;
    public $cute;
    public $name;
    public $apply_specialtime;
    public $start_time;
    public $end_time;
    public $comment;
    
    protected  $dbAdapter;    
    protected $inputFilter;                       // <-- Add this variable
    
    
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->rdate     = (isset($data['rdate'])) ? $data['rdate'] : null;
        $this->isworking     = (isset($data['isworking'])) ? $data['isworking'] : null;
        $this->cute     = (isset($data['cute'])) ? $data['cute'] : null;
        $this->name     = (isset($data['name'])) ? $data['name'] : null;
        $this->apply_specialtime     = (isset($data['apply_specialtime'])) ? $data['apply_specialtime'] : null;        
        $this->start_time     = (isset($data['start_time'])) ? $data['start_time'] : null;
        $this->end_time     = (isset($data['end_time'])) ? $data['end_time'] : null;        
        $this->comment     = (isset($data['comment'])) ? $data['comment'] : null;        
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
      	    
            $dbAdapter = $this->dbAdapter;
      	     
      	    
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
     		    'name'     => 'rdate',
     		    'required' => true,
	               'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     		      'validators' => array(
     		        array(
     		            'name'    => 'Date',
     		            'options' => array(
     		                'format'=>'Y-m-d',
     		                'locale'=> 'ru',
     		                'messages' =>
     		                array(
     		                    \Zend\Validator\Date::INVALID_DATE => 'дата задана неправильно',
     		                )
     		            ),
     		        ),
     		        array(
     		            'name' => 'NotEmpty',
     		            'options' => array(
     		                'messages' => array(
     		                    \Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
     		                ),
     		            ),
     		        ),
     		    ),
     		)));
     		
     		
     		
     		
      		$inputFilter->add($factory->createInput(array(
     				'name'     => 'isworking',
     				'required' => true,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
      		   'validators' => array(
      		        array(
      		            'name'    => 'InArray',
      		            'options' => array(
      		                'haystack' => array('0', '1'),
      		                'strict'   => InArray::COMPARE_STRICT,
      		                'messages' =>
      		                array(
      		                    \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение',
      		                )
      		            ),
      		        ),
      		        array(
      		            'name' => 'NotEmpty',
      		            'options' => array(
      		                'messages' => array(
      		                    \Zend\Validator\NotEmpty::IS_EMPTY => 'поле не может быть пустым".',
      		                ),
      		            ),
      		        ),      		        
      		    ),
     		)));
      		

      		$inputFilter->add($factory->createInput(array(
      		    'name'     => 'cute',
      		    'required' => true,
      		    'filters'  => array(
      		        array('name' => 'StripTags'),
      		        array('name' => 'StringTrim'),
      		    ),
      		    'validators' => array(
      		        array(
      		            'name'    => 'InArray',
      		            'options' => array(
      		                'haystack' => array('0', '1'),
      		                'strict'   => InArray::COMPARE_STRICT,
      		                'messages' =>
      		                array(
      		                    \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение',
      		                )
      		            ),
      		        ),
      		        array(
      		            'name' => 'NotEmpty',
      		            'options' => array(
      		                'messages' => array(
      		                    \Zend\Validator\NotEmpty::IS_EMPTY => 'поле не может быть пустым".',
      		                ),
      		            ),
      		        ),
      		    ),
      		)));
      		
      		
      		
      		
      		
      		$inputFilter->add($factory->createInput(array(
      				'name'     => 'apply_specialtime',
      				'required' => true,
      				'filters'  => array(
      						array('name' => 'StripTags'),
      						array('name' => 'StringTrim'),
      				),
      				'validators' => array(
      						array(
      								'name'    => 'InArray',
      								'options' => array(
      										'haystack' => array('0', '1'),
      										'strict'   => InArray::COMPARE_STRICT,
      										'messages' =>
      										array(
      												\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение',
      										)
      								),
      						),
      						array(
      								'name' => 'NotEmpty',
      								'options' => array(
      										'messages' => array(
      												\Zend\Validator\NotEmpty::IS_EMPTY => 'поле не может быть пустым".',
      										),
      								),
      						),
      				),
      		)));
      		
      		
      		
      		$inputFilter->add($factory->createInput(array(
      				'name'     => 'start_time',
      				'required' => true,
      				'filters'  => array(
      						array('name' => 'StripTags'),
      						array('name' => 'StringTrim'),
      				),
      				'validators' => array(
      						array(
      								'name'    => 'Regex',
      								'options' => array(
      										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
      										'messages'=>
      										array(
      												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
      										)
      								),
      						),
      						array(
      								'name' => 'NotEmpty',
      								'options' => array(
      										'messages' => array(
      												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
      										),
      								),
      						),
      				))));
      		
      		$inputFilter->add($factory->createInput(array(
      				'name'     => 'end_time',
      				'required' => true,
      				'filters'  => array(
      						array('name' => 'StripTags'),
      						array('name' => 'StringTrim'),
      				),
      				'validators' => array(
      						array(
      								'name'    => 'Regex',
      								'options' => array(
      										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
      										'messages'=>
      										array(
      												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
      										)
      								),
      						),
      						array(
      								'name' => 'NotEmpty',
      								'options' => array(
      										'messages' => array(
      												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
      										),
      								),
      						),
      				))));
      		
      		
      		
      		
      		
      		$inputFilter->add($factory->createInput(array(
      		    'name'     => 'name',
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
      		
      		
      		
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'comment',
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
