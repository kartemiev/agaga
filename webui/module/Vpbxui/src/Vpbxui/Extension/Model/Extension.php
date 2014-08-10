<?php
namespace Vpbxui\Extension\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;
use Zend\Validator\Regex as RegexValidator;
use Zend\Db\Adapter\AdapterInterface;

class Extension implements InputFilterAwareInterface
{
    public $id;
    public $extension;
    public $name;
    public $defaultuser;
    public $secret;
    public $custname;
    public $custdesc;
    public $extensiontype;
    public $callerid;
    public $operatorstatus;
    public $extensiongroup;
    public $namedpickupgroup;
    public $namedcallgroup;
    public $outgoingcallspermission;
    public $deny;
    public $permit;    
    public $transfer;
    public $statuschange;
    public $incoming;
    public $hold;
    public $forwarding;
    public $memberofcallcentreque;
    public $email;    
    public $callsequence;
    public $numbers;
    public $busylevel;
    public $diversion_unconditional_status;
    public $diversion_unconditional_number;
    public $diversion_unavail_status;
    public $diversion_unavail_number;
    public $diversion_busy_status;
    public $diversion_busy_number;    
    public $diversion_noanswer_status;
    public $diversion_noanswer_number;
    
    public $diversion_unconditional_landingtype;
    public $diversion_unavail_landingtype;
    public $diversion_busy_landingtype;
    public $diversion_noanswer_landingtype;
	public $diversion_noanswer_duration;
   
    public $number_status;
    public $routeref;
    public $extensionrecord;
    
    public $vpbxid;
    
    protected  $dbAdapter;    
    protected $inputFilter;                       // <-- Add this variable
    
    public function __construct(AdapterInterface $dbAdapter = null)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        
        if (isset($data['extension']))  $this->extension=$data['extension'];
        
        
        $this->name     = (isset($data['name'])) ? $data['name'] : null;        
        $this->callerid     = (isset($data['callerid'])) ? $data['callerid'] : null;                
        $this->secret     = (isset($data['secret'])) ? $data['secret'] : null;
       if (isset($data['extensiontype']))  $this->extensiontype = $data['extensiontype'];
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;        
         $this->operatorstatus = (isset($data['operatorstatus'])) ? $data['operatorstatus'] : null;
        
         $this->extensiongroup = (isset($data['extensiongroup'])) ? $data['extensiongroup'] : null;
        $this->namedpickupgroup     = (isset($data['namedpickupgroup'])) ? $data['namedpickupgroup'] : null;
        $this->namedcallgroup     = (isset($data['namedcallgroup'])) ? $data['namedcallgroup'] : null;       
        $this->outgoingcallspermission = (isset($data['outgoingcallspermission'])) ? $data['outgoingcallspermission'] : null;
               
        $this->deny     = (isset($data['deny'])) ? $data['deny'] : null;
        $this->permit     = (isset($data['permit'])) ? $data['permit'] : null;
        
        $this->transfer     = (isset($data['transfer'])) ? $data['transfer'] : null;
        $this->statuschange     = (isset($data['statuschange'])) ? $data['statuschange'] : null;
        $this->incoming     = (isset($data['incoming'])) ? $data['incoming'] : null;
        $this->hold     = (isset($data['hold'])) ? $data['hold'] : null;
        $this->forwarding     = (isset($data['forwarding'])) ? $data['forwarding'] : null;
        $this->memberofcallcentreque     = (isset($data['memberofcallcentreque'])) ? $data['memberofcallcentreque'] : null;
        $this->email     = (isset($data['email'])) ? $data['email'] : null;
        $this->callsequence     = (isset($data['callsequence'])) ? $data['callsequence'] : null;
        $this->numbers     = (isset($data['numbers'])) ? $data['numbers'] : null;
        $this->defaultuser     = (isset($data['defaultuser'])) ? $data['defaultuser'] : null;
                
        $this->diversion_unconditional_status     = (isset($data['diversion_unconditional_status'])) ? $data['diversion_unconditional_status'] : null;
        $this->diversion_unconditional_number     = (isset($data['diversion_unconditional_number'])) ? $data['diversion_unconditional_number'] : null;
        $this->diversion_unavail_status     = (isset($data['diversion_unavail_status'])) ? $data['diversion_unavail_status'] : null;
        $this->diversion_unavail_number     = (isset($data['diversion_unavail_number'])) ? $data['diversion_unavail_number'] : null;
        $this->diversion_busy_status     = (isset($data['diversion_busy_status'])) ? $data['diversion_busy_status'] : null;
        $this->diversion_noanswer_status     = (isset($data['diversion_noanswer_status'])) ? $data['diversion_noanswer_status'] : null;
        $this->diversion_noanswer_number     = (isset($data['diversion_noanswer_number'])) ? $data['diversion_noanswer_number'] : null;
        $this->number_status     = (isset($data['number_status'])) ? $data['number_status'] : null;
        $this->routeref     = (isset($data['routeref'])) ? $data['routeref'] : null;
        
        
        $this->diversion_unconditional_landingtype     = (isset($data['diversion_unconditional_landingtype'])) ? $data['diversion_unconditional_landingtype'] : null;
        $this->diversion_unavail_landingtype     = (isset($data['diversion_unavail_landingtype'])) ? $data['diversion_unavail_landingtype'] : null;
        $this->diversion_busy_landingtype     = (isset($data['diversion_busy_landingtype'])) ? $data['diversion_busy_landingtype'] : null;
        $this->diversion_noanswer_landingtype     = (isset($data['diversion_noanswer_landingtype'])) ? $data['diversion_noanswer_landingtype'] : null;
        $this->diversion_noanswer_duration     = (isset($data['diversion_noanswer_duration'])) ? $data['diversion_noanswer_duration'] : null;       
        $this->extensionrecord = (isset($data['extensionrecord'])) ? $data['extensionrecord'] : null;
		$this->busylevel = (isset($data['busylevel'])) ? $data['busylevel'] : null;	
		$this->vpbxid = (isset($data['vpbxid'])) ? $data['vpbxid'] : null;
		
     }
     
     public function getArrayCopy()
     {        	 
      	return get_object_vars($this);
     }

      public function setInputFilter(InputFilterInterface $inputFilter)
     {
     	$this->inputFilter = $inputFilter;
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
     				'name'     => 'numbers',
     				'required' => false,
     		)));
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'routeref',
     				'filters'  => array(
     						array('name' => 'Int'),
     				),
     				'required' => false,
     		)));
      		$inputFilter->add($factory->createInput(array(
     				'name'     => 'extension',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'Int'),
     				),
      		    'validators' => array(
      		        array(
      		            'name'    => 'Digits',
      		            'options' => array(
      		                'messages' =>
      		                array(
      		                    \Zend\Validator\Digits::STRING_EMPTY => 'Поле внутреннего номера не может быть пустым',
      		                    \Zend\Validator\Digits::NOT_DIGITS => 'Внутренний номер может состоять только из цифр',
      		                    \Zend\Validator\Digits::INVALID => 'Внутренний номер неверен'
      		                )
      		            ),
      		        ),
      		        array(
      		            'name' => 'NotEmpty',
      		            'options' => array(
      		                'messages' => array(
      		                    \Zend\Validator\NotEmpty::IS_EMPTY => 'Поле внутреннего номера не может быть пустым".',
      		                ),
      		            ),
      		        ),      		        
      		    ),
     		)));
      		
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'extensiontype',
     				'required' => false,     		
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
     		    'required' => true,
     		    'validators' => array(
     		        array(
     		            'name'    => 'InArray',
     		            'options' => array(
     		                'haystack' => array('undefined','active', 'disabled'),
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
     				'name'     => 'name',
     				'required' => true,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     				'validators' => array(
     						array(
     								'name'    => 'Regex',
     								'options' => array(
     								    'pattern' => '/^[\w\s]{1,60}$/',     				
     								    'messages'=>
     								    array(
     								        \Zend\Validator\Regex::NOT_MATCH => 'имя для регистрации абонентского устройства может содержать только латинские буквы и/или цифры (максимум 60 символов)',
     								    )
     								    ),
     								    ),
     								    array(
     								        'name' => 'NotEmpty',
     								        'options' => array(
     								            'messages' => array(
     								                \Zend\Validator\NotEmpty::IS_EMPTY => 'имя для регистрации абонентского устройства не может быть пустым".',
     								            ),
     								        ),
     						),
     				))));

                     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'callerid',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     				'validators' => array(
     						array(
     								'name'    => 'Regex',
      								'options' => array(
                                                              'messages' => array(
                                           RegexValidator:: NOT_MATCH =>
   'имя для отображения на экране телефонного аппарата может содержать только латинские только латинские буквы, цифры и пробел (максимум 10 символов)'                         
                                                                  ),

                                                                'pattern' => '/^[\w\s]{1,50}$/'
     								 
     								),
     						),
     				))));              
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'secret',
     				'required' => true,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     				'validators' => array(
     				    array(
     				        'name' => 'NotEmpty',
     				        'break_chain_on_failure' => true,
     				        'options' => array(
     				            'messages' => array(
     				                \Zend\Validator\NotEmpty::IS_EMPTY => 'пароль не может быть пустым.',
     				            ),
     				        ),
     				    ),
     						array(     						    
     								'name'    => 'StringLength',
     						        'break_chain_on_failure' => true,     						    	
     								'options' => array(
     										'encoding' => 'UTF-8',
     										'min'      => 3,
     										'max'      => 100,
     								    'messages' => array(
     								        \Zend\Validator\StringLength::TOO_SHORT => 'пароль не может быть меньше 3 символов.',     								        
     								    ),
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
      		    ),
     		)));
     		 
     		
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'email',
      		    	
     		    'required' => false,     		    
     		    'filters'  => array(
     		        array('name' => 'StripTags'),
     		        array('name' => 'StringTrim'),
     		    ),
     		    'validators' => array(
      		        array(
     		            'name'    => 'EmailAddress',
      		            'break_chain_on_failure' => true,      		            
        		            'options' => array(
     		                'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck'    => true,
     		                'messages' =>
     		                array(
     		                    \Zend\Validator\EmailAddress::INVALID => 'неправильный адрес',
     		                    \Zend\Validator\EmailAddress::INVALID_FORMAT => 'неправильный формат',
     		                    \Zend\Validator\EmailAddress::INVALID_HOSTNAME => 'неверный домен',
     		                    \Zend\Validator\EmailAddress::INVALID_LOCAL_PART => 'неверный пользователь почтового ящика',
     		                    \Zend\Validator\EmailAddress::INVALID_MX_RECORD => 'такого доменного имени не существует или сервер не принимает почту (отсуствует запись MX)',
     		                    \Zend\Validator\EmailAddress::INVALID_SEGMENT => 'неверный сегмент',
     		                    \Zend\Validator\Hostname::LOCAL_NAME_NOT_ALLOWED => 'локальные адреса доменов не разрешаются',
     		                    \Zend\Validator\Hostname::UNKNOWN_TLD => 'неизвестный домен первого уровня',
     		                    \Zend\Validator\Hostname::INVALID_HOSTNAME_SCHEMA => 'неправильная структура ввода',     		                     
     		                    \Zend\Validator\Hostname::INVALID_HOSTNAME => 'неверное имя домена'     		                     
     		                     
     		                ),
        		                 
     		            ),
     		        ),
     		        
     		    ),
     		)));
     		 
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'callsequence',
     				'required' => true,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('SEQUENTIAL', 'SIMULRING'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));

     		
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_unconditional_status',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('UNDEFINED','ACTIVATED','DEACTIVATED'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
     		 
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'number_status',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('UNDEFINED','ACTIVE','SUSPENDED'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
     		
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_unavail_status',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('UNDEFINED','ACTIVATED','DEACTIVATED'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_busy_status',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('UNDEFINED','ACTIVATED','DEACTIVATED'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_noanswer_status',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('UNDEFINED','ACTIVATED','DEACTIVATED'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_unconditional_number',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     				'validators' => array(
     						array(
     								'name'    => 'Regex',
     								'options' => array(
     										'pattern' => '/^[\d]{1,60}$/',
     										'messages'=>
     										array(
     												\Zend\Validator\Regex::NOT_MATCH => 'номер переадресации может содержать только цифры',
     										)
     								),
     						),
     				))));
           		

     		 

     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_unavail_number',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     				'validators' => array(
     						array(
     								'name'    => 'Regex',
     								'options' => array(
     										'pattern' => '/^[\d]{1,60}$/',
     										'messages'=>
     										array(
     												\Zend\Validator\Regex::NOT_MATCH => 'номер переадресации может содержать только цифры',
     										)
     								),
     						),
     				))));
     		 

     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_busy_number',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     				'validators' => array(
     						array(
     								'name'    => 'Regex',
     								'options' => array(
     										'pattern' => '/^[\d]{1,60}$/',
     										'messages'=>
     										array(
     												\Zend\Validator\Regex::NOT_MATCH => 'номер переадресации может содержать только цифры',
     										)
     								),
     						),
     				))));
     		 
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_noanswer_number',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     				'validators' => array(
     						array(
     								'name'    => 'Regex',
     								'options' => array(
     										'pattern' => '/^[\d]{1,60}$/',
     										'messages'=>
     										array(
     												\Zend\Validator\Regex::NOT_MATCH => 'номер переадресации может содержать только цифры',
     										)
     								),
     						),
     				))));

     		 
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_unconditional_landingtype',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('NUMBER','VOICEMAIL','FAX'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
     		 
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_unavail_landingtype',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('NUMBER','VOICEMAIL','FAX'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_busy_landingtype',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('NUMBER','VOICEMAIL','FAX'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_noanswer_landingtype',
     				'required' => false,
     				'validators' => array(
     						array(
     								'name'    => 'InArray',
     								'options' => array(
     										'haystack' => array('NUMBER','VOICEMAIL','FAX'),
     										'strict'   => InArray::COMPARE_STRICT
     								),
     								'messages' => array(
     										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
     								),
     						),
     				),
     		)));
      		$inputFilter->add($factory->createInput(array(
     				'name'     => 'diversion_noanswer_duration',
     				'required' => true,
     				'filters'  => array(
     						array('name' => 'Int'),
     				),
     		)));
     		$this->inputFilter = $inputFilter;
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'busylevel',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'Int'),
     				),
     		)));
     		 
     	}
     
     	
     	 
     	
     	
     	return $this->inputFilter;
     }
 }
