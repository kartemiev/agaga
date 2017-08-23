<?php
namespace Vpbxui\Trunk\Model;

use Zend\InputFilter\Factory as InputFactory;  
use Zend\InputFilter\InputFilter;                  
use Zend\InputFilter\InputFilterAwareInterface;    
use Zend\InputFilter\InputFilterInterface;       
use Zend\Validator\InArray;
use Zend\Validator\Regex as RegexValidator;
use Zend\Db\Adapter\AdapterInterface;

class Trunk implements InputFilterAwareInterface
{
	public $id;
	public $secret;
	public $custname;
	public $custdesc;
	public $callerid;
	public $host;
	public $callbackextension;
	public $context;
	public $insecure;	
	public $peertype;
	public $name;
	public $defaultuser;
	public $port;
 	
 	
	protected $inputFilter;                      
	
	
	public function exchangeArray($data)
	{
        $this->id     		= (isset($data['id'])) ? $data['id'] : null;
        $this->secret     	= (isset($data['secret'])) ? $data['secret'] : null;
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->name     	= (isset($data['name'])) ? $data['name'] : null;        
        $this->callerid     = (isset($data['callerid'])) ? $data['callerid'] : null;
        $this->host     	= (isset($data['host'])) ? $data['host'] : null;
        $this->callbackextension  = (isset($data['callbackextension'])) ? $data['callbackextension'] : null;
        $this->context     = (isset($data['context'])) ? $data['context'] : null;
        $this->insecure     = (isset($data['insecure'])) ? $data['insecure'] : null;   
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null; 
        $this->peertype     = (isset($data['peertype'])) ? $data['peertype'] : null;   
        $this->defaultuser     = (isset($data['defaultuser'])) ? $data['defaultuser'] : null;
        $this->port     = (isset($data['port'])) ? $data['port'] : null;
        
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
					'name'     => 'callerid',
					'required' => false,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
			 )));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'name',
					'required' => false,					 
					'validators' => array(
							array(
									'name'    => 'Regex',
									'options' => array(
											'messages' => array(
													RegexValidator:: NOT_MATCH =>
													'имя для для регистрации может содержать только латинские только латинские буквы, цифры и пробел (от 10 до 60 символов)'
											),
												
											'pattern' => '/^[\w\s]{1,60}$/'
		
									),
							),
					))));
				
			$inputFilter->add($factory->createInput(array(
					'name'     => 'host',
					'required' => false,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'Hostname',
									'options' => array(
											'allow' =>  \Zend\Validator\Hostname::ALLOW_ALL,
 											'messages' => array(
													\Zend\Validator\Hostname::CANNOT_DECODE_PUNYCODE  => 'неправильное имя домена',
													\Zend\Validator\Hostname::INVALID                   => 'неправильное имя домена',
													\Zend\Validator\Hostname::INVALID_DASH              => 'неправильное имя домена',
													\Zend\Validator\Hostname::INVALID_HOSTNAME          => 'неправильное имя домена',
													\Zend\Validator\Hostname::INVALID_HOSTNAME_SCHEMA   => 'неправильное имя домена',
													\Zend\Validator\Hostname::INVALID_LOCAL_NAME        => 'неправильное имя домена',
													\Zend\Validator\Hostname::INVALID_URI               => 'неправильное имя домена',
													\Zend\Validator\Hostname::IP_ADDRESS_NOT_ALLOWED    => 'неправильное имя домена',
													\Zend\Validator\Hostname::LOCAL_NAME_NOT_ALLOWED    => 'неправильное имя домена',
													\Zend\Validator\Hostname::UNDECIPHERABLE_TLD        => 'неправильное имя домена',
													\Zend\Validator\Hostname::UNKNOWN_TLD               => 'неправильное имя домена',														
 											),
 									),
							),
					))));

			$inputFilter->add($factory->createInput(array(
					'name'     => 'insecure',
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
													'поле может содержать только латинские буквы, пробел и запятую'
											),												
											'pattern' => '/^[\,\w\s]{1,60}$/'
		
									),
							),
					))));
			
			$inputFilter->add($factory->createInput(array(
					'name'     => 'callbackextension',
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
													'поле может содержать только латинские буквы, цифри и/или подчеркивание'
											),
											'pattern' => '/^[\w_]{1,60}$/'
			
									),
							),
					))));
				
			$inputFilter->add($factory->createInput(array(
					'name'     => 'port',
					'required' => false,
					'filters'  => array(
							array('name' => 'Int'),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'csrf',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'Csrf',
									'options' => array(
											'messages' => array(
													\Zend\Validator\Csrf:: NOT_SAME => 'форма устарела'
											),			
									),
							),
					))));
			$this->inputFilter = $inputFilter;
				
			}
			return $this->inputFilter;
				
	}
}