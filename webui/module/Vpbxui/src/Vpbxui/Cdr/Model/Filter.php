<?php
namespace Vpbxui\Cdr\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;
use Zend\Validator\Regex as RegexValidator;
  
class Filter implements InputFilterAwareInterface
{            
	public $startdate;
	public $enddate;
	public $calldest;
	public $callerid;
	public $calldirection;
	public $itemsperpage;
	public $onlyrecorded;
	protected  $inputFilter;
	public function exchangeArray($data)
	{
		$data = array_filter(
				$data,
				function($column){
						return  (''!==$column);
					}
				);		 
 
 		$this->startdate     = (isset($data['startdate'])) ? $data['startdate'] : null;
		$this->enddate     = (isset($data['enddate'])) ? $data['enddate'] : null;
		$this->calldest     = (isset($data['calldest'])) ? $data['calldest'] : null;
		$this->callerid     = (isset($data['callerid'])) ? $data['callerid'] : null;
		$this->calldirection     = (isset($data['calldirection'])) ? $data['calldirection'] : null;
		$this->itemsperpage     = (isset($data['itemsperpage'])) ? $data['itemsperpage'] : null;
		$this->onlyrecorded     = (isset($data['onlyrecorded'])) ? $data['onlyrecorded'] : null;
		
	}
	 
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
		
		$inputFilter = new InputFilter();
		$factory     = new InputFactory();
		 
		$inputFilter->add($factory->createInput(array(
				'name'     => 'startdate',
				'required' => false,
				 
		)));
		$inputFilter->add($factory->createInput(array(
				'name'     => 'enddate',
				'required' => false,
		
		)));
		$inputFilter->add($factory->createInput(array(
				'name'     => 'calldest',
				'required' => false,
				 
		)));
		$inputFilter->add($factory->createInput(array(
				'name'     => 'callerid',
				'required' => false,
		
		)));
		$inputFilter->add($factory->createInput(array(
				'name'     => 'calldirection',
				'required' => false,
				 
		)));
		$inputFilter->add($factory->createInput(array(
				'name'     => 'itemsperpage',
				'required' => false,
		
		)));
		$inputFilter->add($factory->createInput(array(
				'name'     => 'onlyrecorded',
				'required' => false,
		
		)));
 		$this->inputFilter = $inputFilter;
		}		  		
		return $this->inputFilter;
	}
	 public function setInputFilter(InputFilterInterface $inputFilter)
     {
     	throw new \Exception("Not used");
     }
}