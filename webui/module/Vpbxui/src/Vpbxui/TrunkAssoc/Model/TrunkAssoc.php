<?php
namespace Vpbxui\TrunkAssoc\Model;
 
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class TrunkAssoc  implements InputFilterAwareInterface
{ 
    public $id;
    public $trunkref;
    public $contextref;
    protected $inputFilter;
    
     
    public function exchangeArray($data)
    {
    	$this->id     = (isset($data['id'])) ? $data['id'] : null;
    	$this->trunkref     = (isset($data['trunkref'])) ? $data['trunkref'] : null;
    	$this->contextref     = (isset($data['contextref'])) ? $data['contextref'] : null;    
    }
     
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }     
    public function setTrunkref($trunkref)
    {
        $this->trunkref = $trunkref;
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
    				'name'     => 'trunkref',
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