<?php
namespace Vpbxui\AuthCode\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Db\Adapter\AdapterInterface;

class AuthCode
{
    public $vpbx_id; 
 	public $pincode;
    
    protected $inputFilter;
    public function exchangeArray($data)
    {
    	$this->vpbx_id     = (isset($data['vpbx_id'])) ? $data['vpbx_id'] : null;    	 
    	$this->pincode     = (isset($data['pincode'])) ? $data['pincode'] : null;
    	 
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
    				'name'     => 'vpbx_id',
    				'required' => false,
    				'filters'  => array(
    						array('name' => 'Int'),
    				),
    		)));
    		 
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'pincode',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'String'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Digits',
    								'options' => array(
    										'messages' =>
    										array(
    												\Zend\Validator\Digits::STRING_EMPTY => 'ПИН код не может быть пустым',
    												\Zend\Validator\Digits::NOT_DIGITS => 'ПИН код может состоять только из цифр',
    												\Zend\Validator\Digits::INVALID => 'ПИН код неверен'
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'ПИН код не может быть пустым".',
    										),
    								),
    						),
    				),
    		)));
    	}	 
    	return $this->inputFilter;
    }
}