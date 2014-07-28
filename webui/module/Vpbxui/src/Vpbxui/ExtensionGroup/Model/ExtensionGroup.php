<?php
namespace Vpbxui\ExtensionGroup\Model;


use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray; 
use Zend\Validator\Regex as RegexValidator;

class ExtensionGroup implements InputFilterAwareInterface
{
    public $id;
    public $name;
    public $transfer;
    public $statuschange;
    public $incoming;
    public $memberofcallcentreque;
    public $hold;
    public $forwarding;
    public $custdesc;
    public $number_status;
     
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
    public $extensionrecord;
    public $vpbxid;
    
    
    protected $inputFilter;                       // <-- Add this variable
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->name     = (isset($data['name'])) ? $data['name'] : null;        
        $this->transfer     = (isset($data['transfer'])) ? $data['transfer'] : null;        
        $this->statuschange     = (isset($data['statuschange'])) ? $data['statuschange'] : null;
        $this->incoming     = (isset($data['incoming'])) ? $data['incoming'] : null;
        $this->memberofcallcentreque     = (isset($data['memberofcallcentreque'])) ? $data['memberofcallcentreque'] : null;
        $this->hold     = (isset($data['hold'])) ? $data['hold'] : null;
        $this->forwarding     = (isset($data['forwarding'])) ? $data['forwarding'] : null; 
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;    
        $this->number_status     = (isset($data['number_status'])) ? $data['number_status'] : null;    
        
        $this->diversion_unconditional_status     = (isset($data['diversion_unconditional_status'])) ? $data['diversion_unconditional_status'] : null;
        $this->diversion_unconditional_number     = (isset($data['diversion_unconditional_number'])) ? $data['diversion_unconditional_number'] : null;
        $this->diversion_unavail_status     = (isset($data['diversion_unavail_status'])) ? $data['diversion_unavail_status'] : null;
        $this->diversion_unavail_number     = (isset($data['diversion_unavail_number'])) ? $data['diversion_unavail_number'] : null;
        $this->diversion_busy_status     = (isset($data['diversion_busy_status'])) ? $data['diversion_busy_status'] : null;
        $this->diversion_noanswer_status     = (isset($data['diversion_noanswer_status'])) ? $data['diversion_noanswer_status'] : null;
        $this->diversion_noanswer_number     = (isset($data['diversion_noanswer_number'])) ? $data['diversion_noanswer_number'] : null;
                
        $this->diversion_unconditional_landingtype     = (isset($data['diversion_unconditional_landingtype'])) ? $data['diversion_unconditional_landingtype'] : null;
        $this->diversion_unavail_landingtype     = (isset($data['diversion_unavail_landingtype'])) ? $data['diversion_unavail_landingtype'] : null;
        $this->diversion_busy_landingtype     = (isset($data['diversion_busy_landingtype'])) ? $data['diversion_busy_landingtype'] : null;
        $this->diversion_noanswer_landingtype     = (isset($data['diversion_noanswer_landingtype'])) ? $data['diversion_noanswer_landingtype'] : null;
        $this->diversion_noanswer_duration     = (isset($data['diversion_noanswer_duration'])) ? $data['diversion_noanswer_duration'] : null;
        
        $this->extensionrecord = (isset($data['extensionrecord'])) ? $data['extensionrecord'] : null;
        $this->vpbxid = (isset($data['vpbxid'])) ? $data['vpbxid'] : null;
        
        
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
     				'name'     => 'name',
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
     								),
     						),
     				))));
                     		
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
                     		                'max'      => 250,
                     		            ),
                     		        ),
                     		    ))));

                     		$inputFilter->add($factory->createInput(array(
                     				'name'     => 'memberofcallcentreque',
                     				'required' => false,
                     				'validators' => array(
                     						array(
                     								'name'    => 'InArray',
                     								'options' => array(
                     										'haystack' => array('undefined','true','false'),
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
                     				'required' => false,
                     				'filters'  => array(
                     						array('name' => 'Int'),
                     				),
                     		)));                     		 
     		$this->inputFilter = $inputFilter;
     	}
     
     	return $this->inputFilter;
     }
}
