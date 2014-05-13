<?php
namespace Vpbxui\GeneralSettings\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray; 

class GeneralSettings implements InputFilterAwareInterface
{
    public $vpbxid;
    public $vmtimeout;
    public $greeting;
    public $mohtone;
    public $ringingtone;
    public $greetingofftime;
    public $mohinternal;
    protected $inputFilter;                 
    
    public function exchangeArray($data)
    {
        $this->vpbxid     = (isset($data['vpbxid'])) ? $data['vpbxid'] : null;        
        $this->vmtimeout     = (isset($data['vmtimeout'])) ? $data['vmtimeout'] : null;
        $this->greeting     = (isset($data['greeting'])) ? $data['greeting'] : null;
        $this->greetingofftime     = (isset($data['greetingofftime'])) ? $data['greetingofftime'] : null;
        $this->mohtone     = (isset($data['mohtone'])) ? $data['mohtone'] : null;
        $this->ringingtone     = (isset($data['ringingtone'])) ? $data['ringingtone'] : null;          
        $this->mohinternal     = (isset($data['mohinternal'])) ? $data['mohinternal'] : null;        
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
     		    'name'     => 'vmtimeout',
     		    'required' => true,
     		    'filters'  => array(
     		        array('name' => 'Int'),
     		    ),
     		)));
     		
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'greeting',
     		    'required' => false,
     		    'filters'  => array(
     		        array('name' => 'Int'),
     		    ),
     		)));
     		
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'greetingofftime',
     		    'required' => false,
     		    'filters'  => array(
     		        array('name' => 'Int'),
     		    ),
     		)));
     		
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'mohtone',
     		    'required' => false,
     		    'filters'  => array(
     		        array('name' => 'Int'),
     		    ),
     		)));
     		
     		$inputFilter->add($factory->createInput(array(
     		    'name'     => 'ringingtone',
     		    'required' => false,
     		    'filters'  => array(
     		        array('name' => 'Int'),
     		    ),
     		)));
     		
     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'ringingtone',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'Int'),
     				),
     		)));
     		

     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'mohinternal',
     				'required' => true,
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
     		 
     		
     		$this->inputFilter = $inputFilter;
     	}
     
     	return $this->inputFilter;
     }
}
