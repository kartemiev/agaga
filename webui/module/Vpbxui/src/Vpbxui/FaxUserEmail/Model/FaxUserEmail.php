<?php
namespace Vpbxui\FaxUserEmail\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class FaxUserEmail implements InputFilterAwareInterface
{
    public $userref; 
    public $email;
    protected $inputFilter;
    public function exchangeArray($data)
    {
        $this->userref = (isset($data['userref']))? $data['userref']:null;
        $this->email = (isset($data['email']))? $data['email']:null;
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
    				'name'     => 'userref',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'Int'),
    				),
    		)));
    		 
      
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'email',
    				'required' => true,
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
    		$this->inputFilter = $inputFilter;
    	}
    	 
    	return $this->inputFilter;
    }
}