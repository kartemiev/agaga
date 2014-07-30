<?php
namespace Did\PickDid\Model;

use Zend\InputFilter\Factory as InputFactory;   
use Zend\InputFilter\InputFilter;                 
use Zend\InputFilter\InputFilterAwareInterface;   
use Zend\InputFilter\InputFilterInterface;   

class PickDid implements InputFilterAwareInterface
{
	public $did;
	public function exchangeArray($data)
	{
		$this->id = (isset($data['did']))? $data['did']:null;
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
					'name'     => 'did',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			)));
			 
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}	
}