<?php
namespace Vpbxui\TrunkDestination\Model;

use Zend\InputFilter\Factory as InputFactory;  
use Zend\InputFilter\InputFilter;                  
use Zend\InputFilter\InputFilterAwareInterface;    
use Zend\InputFilter\InputFilterInterface;       
use Zend\Validator\InArray;
use Zend\Validator\Regex as RegexValidator;
use Zend\Db\Adapter\AdapterInterface;

class TrunkDestination implements InputFilterAwareInterface
{
 	public $routeref;
	public $trunkref; 
 	public $numbermatchref;	
	protected $inputFilter;                      
		
	public function exchangeArray($data)
	{
        $this->routeref     		= (isset($data['routeref'])) ? $data['routeref'] : null;
        $this->trunkref     		= (isset($data['trunkref'])) ? $data['trunkref'] : null;
        $this->numbermatchref     		= (isset($data['numbermatchref'])) ? $data['numbermatchref'] : null;        
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
					'name'     => 'routeref',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'trunkref',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'numbermatchref',
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