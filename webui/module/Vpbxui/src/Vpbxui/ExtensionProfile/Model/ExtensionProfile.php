<?php
namespace Vpbxui\ExtensionProfile\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;
use Zend\Validator\Regex as RegexValidator;
use Zend\Db\Adapter\AdapterInterface;

class ExtensionProfile implements InputFilterAwareInterface
{  
    public $id;
    public $profilename;
    public $profiledesc;
    public $extensiontype;
     public $operatorstatus;
    public $extensionrecord;
    public $extensiongroup;
    public $namedpickupgroup;
    public $namedcallgroup;
    public $outgoingcallspermission;
        
    public $transfer;
    public $statuschange;
    public $incoming;
    public $hold;
    public $forwarding;
    public $memberofcallcentreque;
    
    protected  $dbAdapter;    
    protected $inputFilter;                       // <-- Add this variable
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;        
        $this->profilename     = (isset($data['profilename'])) ? $data['profilename'] : null;   
        $this->profiledesc     = (isset($data['profiledesc'])) ? $data['profiledesc'] : null;
        
        $this->extensiontype = (isset($data['extensiontype'])) ? $data['extensiontype'] : null;
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;
        $this->operatorstatus = (isset($data['operatorstatus'])) ? $data['operatorstatus'] : null;
        $this->extensionrecord = (isset($data['extensionrecord'])) ? $data['extensionrecord'] : null;
        $this->extensiongroup = (isset($data['extensiongroup'])) ? $data['extensiongroup'] : null;
        $this->namedpickupgroup     = (isset($data['namedpickupgroup'])) ? $data['namedpickupgroup'] : null;
        $this->namedcallgroup     = (isset($data['namedcallgroup'])) ? $data['namedcallgroup'] : null;       
        $this->outgoingcallspermission = (isset($data['outgoingcallspermission'])) ? $data['outgoingcallspermission'] : null;
               
        $this->transfer     = (isset($data['transfer'])) ? $data['transfer'] : null;
        $this->statuschange     = (isset($data['statuschange'])) ? $data['statuschange'] : null;
        $this->incoming     = (isset($data['incoming'])) ? $data['incoming'] : null;
        $this->hold     = (isset($data['hold'])) ? $data['hold'] : null;
        $this->forwarding     = (isset($data['forwarding'])) ? $data['forwarding'] : null;
        $this->memberofcallcentreque     = (isset($data['memberofcallcentreque'])) ? $data['memberofcallcentreque'] : null;
        
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
     		    'name'     => 'profilename',
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
     				'name'     => 'extensiontype',
     				'required' => true,     		
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
                                        'haystack' => array('regular', 'operator','fax'),
                                        'strict'   => InArray::COMPARE_STRICT, 
     								    'messages' => array(
     								        \Zend\Validator\InArray::NOT_IN_ARRAY => 'задано неверное значение".',
     								    ),
              								),
     						),     				    
     				),
     		)));

     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'extensiongroup',
     		    'required' => true,
     		    'validators' => array(
     		        array(
     		            'name'    => 'Zend\Validator\Db\RecordExists',
     		            'options' => array(
     		                'adapter' => $dbAdapter,
     		                'table' => 'extensiongroups',
     		                'field'   => 'id',
     		                'messages' => array(
     								        \Zend\Validator\Db\RecordExists::ERROR_NO_RECORD_FOUND => 'такой группы внутренних номеров не существует".',
     								    ),
     		            ),
     		        ),
     		    ),
     		)));
     		 
     		
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'namedpickupgroup',
     		    'required' => true,
     		    'validators' => array(
     		        array(
     		            'name'    => 'Zend\Validator\Db\RecordExists',
     		            'options' => array(
     		                'adapter' => $dbAdapter,
     		                'table' => 'pickupgroup',
     		                'field'   => 'name',
     		                'messages' => array(
     								        \Zend\Validator\Db\RecordExists::ERROR_NO_RECORD_FOUND => 'такой группы перехвата не существует".',
     								    ),
     		            ),
     		        ),
     		    ),
     		)));
     		 
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'namedcallgroup',
     		    'required' => true,
     		    'validators' => array(
     		        array(
     		            'name'    => 'Zend\Validator\Db\RecordExists',
     		            'options' => array(
     		                'adapter' => $dbAdapter,     		                 
     		                'table' => 'pickupgroup',
     		                'field'   => 'name',
     		                'messages' => array(
     								        \Zend\Validator\Db\RecordExists::ERROR_NO_RECORD_FOUND => 'такой группы перехвата не существует".',
     								    ),
     		            ),
     		                 		        ),
     		    ),
     		)));
     		
     		
     		
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'outgoingcallspermission',
     		    'required' => true,
     		    'validators' => array(
     		        array(
     		            'name'    => 'InArray',
     		            'options' => array(
     		                'haystack' => array('allowed', 'barred','undefined'),
     		                'strict'   => InArray::COMPARE_STRICT
     		            ),
     		            'messages' => array(
     		                \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     		            ),
     		        ),
     		    ),
     		)));
     		
     		
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'extensionrecord',
     		    'required' => false,
     		    'validators' => array(
     		        array(
     		            'name'    => 'InArray',
     		            'options' => array(
     		                'haystack' => array('active', 'disabled'),
     		                'strict'   => InArray::COMPARE_STRICT,
     		                'messages' => array(
     		                    \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     		                ),
     		            ),
     		        ),
     		    ),
     		)));
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'memberofcallcentreque',
     		    'required' => false,
     		    'validators' => array(
     		        array(
     		            'name'    => 'InArray',
     		            'options' => array(
     		                'haystack' => array('undefined', 'true','false'),
     		                'strict'   => InArray::COMPARE_STRICT
     		            ),
     		            'messages' => array(
     		                \Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     		            ),
     		        ),
     		    ),
     		)));
                
  
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
