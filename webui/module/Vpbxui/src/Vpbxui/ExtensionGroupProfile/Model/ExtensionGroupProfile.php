<?php
namespace Vpbxui\ExtensionGroupProfile\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray; 

class ExtensionGroupProfile implements InputFilterAwareInterface
{
    public $id;
    public $profilename;
    public $profiledesc;    
    public $transfer;
    public $statuschange;
    public $incoming;
    public $memberofcallcentreque;
    public $hold;
    public $forwarding;
    public $custdesc;
    public $vpbxid;
    
    protected $inputFilter;                       // <-- Add this variable
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->profilename     = (isset($data['profilename'])) ? $data['profilename'] : null;    
        $this->profiledesc     = (isset($data['profiledesc'])) ? $data['profiledesc'] : null;        
        $this->transfer     = (isset($data['transfer'])) ? $data['transfer'] : null;        
        $this->statuschange     = (isset($data['statuschange'])) ? $data['statuschange'] : null;
        $this->incoming     = (isset($data['incoming'])) ? $data['incoming'] : null;
        $this->memberofcallcentreque     = (isset($data['memberofcallcentreque'])) ? $data['memberofcallcentreque'] : null;
        $this->hold     = (isset($data['hold'])) ? $data['hold'] : null;
        $this->forwarding     = (isset($data['forwarding'])) ? $data['forwarding'] : null; 
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;        
        $this->vpbxid      = (isset($data['vpbxid'])) ? $data['vpbxid'] : null;      
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
     				'name'     => 'profilename',
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
                     		
                     		$inputFilter->add($factory->createInput(array(
                     		    'name'     => 'profiledesc',
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
                     		                'max'      => 255,
                     		            ),
                     		        ),
                     		    ))));
                     		
                     		
                     		$inputFilter->add($factory->createInput(array(
                     		    'name'     => 'transfer',
                     		    'required' => false,
                     		    'validators' => array(
                     		        array(
                     		            'name'    => 'InArray',
                     		            'options' => array(
                     		                'haystack' => array('undefined', 'allowed','forbidden'),
                     		                'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
                     		            ),
                     		            'messages' => array(
                     		                \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
                     		            ),
                     		        ),
                     		    ),
                     		)));
                     		 
                     		$inputFilter->add($factory->createInput(array(
                     		    'name'     => 'statuschange',
                     		    'required' => false,
                     		    'validators' => array(
                     		        array(
                     		            'name'    => 'InArray',
                     		            'options' => array(
                     		                'haystack' => array('undefined', 'allowed','forbidden'),
                     		                'strict'   => InArray::COMPARE_STRICT
                     		            ),
                     		            'messages' => array(
                     		                \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
                     		            ),
                     		        ),
                     		    ),
                     		)));
                     		$inputFilter->add($factory->createInput(array(
                     		    'name'     => 'incoming',
                     		    'required' => false,
                     		    'validators' => array(
                     		        array(
                     		            'name'    => 'InArray',
                     		            'options' => array(
                     		                'haystack' => array('undefined', 'allowed','forbidden'),
                     		                'strict'   => InArray::COMPARE_STRICT
                     		            ),
                     		            'messages' => array(
                     		                \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
                     		            ),
                     		        ),
                     		    ),
                     		)));
              
                     		
                     		$inputFilter->add($factory->createInput(array(
                     		    'name'     => 'hold',
                     		    'required' => false,
                     		    'validators' => array(
                     		        array(
                     		            'name'    => 'InArray',
                     		            'options' => array(
                     		                'haystack' => array('undefined', 'allowed','forbidden'),
                     		                'strict'   => InArray::COMPARE_STRICT
                     		            ),
                     		            'messages' => array(
                     		                \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
                     		            ),
                     		        ),
                     		    ),
                     		)));                     		 
                     		$inputFilter->add($factory->createInput(array(
                     		    'name'     => 'forwarding',
                     		    'required' => false,
                     		    'validators' => array(
                     		        array(
                     		            'name'    => 'InArray',
                     		            'options' => array(
                     		                'haystack' => array('undefined', 'allowed','forbidden'),
                     		                'strict'   => InArray::COMPARE_STRICT
                     		            ),
                     		            'messages' => array(
                     		                \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
                     		            ),
                     		        ),
                     		    ),
                     		)));                    
                  
     		$this->inputFilter = $inputFilter;
     	}
     
     	return $this->inputFilter;
     }
}
