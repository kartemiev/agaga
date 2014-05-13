<?php
namespace Vpbxui\RegEntry\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class RegEntry  implements InputFilterAwareInterface
{ 
    public $numbermatchref;
    public $regexpression;

    protected $inputFilter;
     
    public function exchangeArray($data)
    {
     	$this->numbermatchref     = (isset($data['numbermatchref'])) ? $data['numbermatchref'] : null;
    	$this->regexpression     = (isset($data['regexpression'])) ? $data['regexpression'] : null;    
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
    				'name'     => 'numbermatchref',
    				'required' => false,    				 
    		)));
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'regexpression',
    				'required' => false,
    		)));    		 
    		 
    		 
   
    		$this->inputFilter = $inputFilter;
    	}
    	 
    	return $this->inputFilter;
    }
}