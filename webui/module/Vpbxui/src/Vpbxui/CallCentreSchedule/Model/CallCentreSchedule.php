<?php
namespace Vpbxui\CallCentreSchedule\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;
use Zend\Validator\Regex as RegexValidator;
use Zend\Db\Adapter\AdapterInterface;

class CallCentreSchedule
{
    public $vpbx_id; 
	public $s_monday;
	public $e_monday;
	public $active_monday;
	public $s_tuesday; 
	public $e_tuesday;
	public $active_tuesday;
	public $s_wednesday; 
	public $e_wednesday;
	public $active_wednesday;
	public $s_thursday; 
	public $e_thursday;
	public $active_thursday;
	public $s_friday; 
	public $e_friday;
	public $active_friday;
	public $s_saturday; 
	public $e_saturday;
	public $active_saturday;
	public $s_sunday; 
	public $e_sunday;
	public $active_sunday;
	public $s_shortday;
	public $e_shortday;
	public $s_regularwd;
	public $e_regularwd;
	
    protected $inputFilter;
    public function exchangeArray($data)
    {
        $this->s_monday     = (isset($data['s_monday'])) ? $data['s_monday'] : '09:00';
        $this->e_monday     = (isset($data['e_monday'])) ? $data['e_monday'] : '18:00';        
        $this->active_monday     = (isset($data['active_monday'])) ? $data['active_monday'] : true;
        $this->s_tuesday     = (isset($data['s_tuesday'])) ? $data['s_tuesday'] : '09:00';        
        $this->e_tuesday     = (isset($data['e_tuesday'])) ? $data['e_tuesday'] : '18:00';
        $this->active_tuesday     = (isset($data['active_tuesday'])) ? $data['active_tuesday'] : true;  
        $this->s_wednesday     = (isset($data['s_wednesday'])) ? $data['s_wednesday'] : '09:00';
        $this->e_wednesday     = (isset($data['e_wednesday'])) ? $data['e_wednesday'] : '18:00';
        $this->active_wednesday     = (isset($data['active_wednesday'])) ? $data['active_wednesday'] : true;
        $this->s_thursday     = (isset($data['s_thursday'])) ? $data['s_thursday'] : '09:00';;        
        $this->e_thursday     = (isset($data['e_thursday'])) ? $data['e_thursday'] : '18:00';;        
        $this->active_thursday     = (isset($data['active_thursday'])) ? $data['active_thursday'] : true;                        
        $this->s_friday     = (isset($data['s_friday'])) ? $data['s_friday'] : '09:00';
        $this->e_friday     = (isset($data['e_friday'])) ? $data['e_friday'] : '18:00';
        $this->active_friday     = (isset($data['active_friday'])) ? $data['active_friday'] : true;
        $this->s_saturday     = (isset($data['s_saturday'])) ? $data['s_saturday'] : '00:00';
        $this->e_saturday     = (isset($data['e_saturday'])) ? $data['e_saturday'] : '00:00';
        $this->active_saturday     = (isset($data['active_saturday'])) ? $data['active_saturday'] : false;        
        $this->s_sunday     = (isset($data['s_sunday'])) ? $data['s_sunday'] : '00:00';
        $this->e_sunday     = (isset($data['e_sunday'])) ? $data['e_sunday'] : '00:00';
        $this->active_sunday     = (isset($data['active_sunday'])) ? $data['active_sunday'] : false;        
        $this->s_shortday     = (isset($data['s_shortday'])) ? $data['s_shortday'] : '00:00';
        $this->e_shortday     = (isset($data['e_shortday'])) ? $data['e_shortday'] : '00:00';
        $this->s_regularwd     = (isset($data['s_regularwd'])) ? $data['s_regularwd'] : '00:00';
        $this->e_regularwd     = (isset($data['e_regularwd'])) ? $data['e_regularwd'] : '00:00';
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
    				'name'     => 's_monday',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Regex',
    								'options' => array(
    										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    										'messages'=>
    										array(
    												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    										),
    								),
    						),
    				))));
    
    		 
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'e_monday',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Regex',
    								'options' => array(
    										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    										'messages'=>
    										array(
    												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    										),
    								),
    						),
    				))));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'active_monday',
    				'required' => false,
    				'validators' => array(
    						array(
    								'name'    => 'InArray',
    								'options' => array(
    										'haystack' => array('0','1'),
    										'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
    								),
    								'messages' => array(
    										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
    								),
    						),
    				),
    		)));

    		$inputFilter->add($factory->createInput(array(
    				'name'     => 's_tuesday',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Regex',
    								'options' => array(
    										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    										'messages'=>
    										array(
    												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    										),
    								),
    						),
    				))));
    		
    		 
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'e_tuesday',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Regex',
    								'options' => array(
    										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    										'messages'=>
    										array(
    												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    										),
    								),
    						),
    				))));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'active_tuesday',
    				'required' => false,
    				'validators' => array(
    						array(
    								'name'    => 'InArray',
    								'options' => array(
    										'haystack' => array('0','1'),
    										'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
    								),
    								'messages' => array(
    										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
    								),
    						),
    				),
    		)));


    		$inputFilter->add($factory->createInput(array(
    				'name'     => 's_wednesday',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Regex',
    								'options' => array(
    										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    										'messages'=>
    										array(
    												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    										),
    								),
    						),
    				))));
    		
    		 
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'e_wednesday',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Regex',
    								'options' => array(
    										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    										'messages'=>
    										array(
    												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    										),
    								),
    						),
    				))));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'active_wednesday',
    				'required' => false,
    				'validators' => array(
    						array(
    								'name'    => 'InArray',
    								'options' => array(
    										'haystack' => array('0','1'),
    										'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
    								),
    								'messages' => array(
    										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
    								),
    						),
    				),
    		)));
    		

    		$inputFilter->add($factory->createInput(array(
    				'name'     => 's_thursday',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Regex',
    								'options' => array(
    										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    										'messages'=>
    										array(
    												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    										),
    								),
    						),
    				))));
    		
    		 
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'e_thursday',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'Regex',
    								'options' => array(
    										'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    										'messages'=>
    										array(
    												\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    										)
    								),
    						),
    						array(
    								'name' => 'NotEmpty',
    								'options' => array(
    										'messages' => array(
    												\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    										),
    								),
    						),
    				))));
    		
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'active_thursday',
    				'required' => false,
    				'validators' => array(
    						array(
    								'name'    => 'InArray',
    								'options' => array(
    										'haystack' => array('0','1'),
    										'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
    								),
    								'messages' => array(
    										\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
    								),
    						),
    				),
    		)));
    		
    		$this->inputFilter = $inputFilter;
    	}
    	 

    	$inputFilter->add($factory->createInput(array(
    			'name'     => 's_friday',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	
    	 
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 'e_friday',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 'active_friday',
    			'required' => false,
    			'validators' => array(
    					array(
    							'name'    => 'InArray',
    							'options' => array(
    									'haystack' => array('0','1'),
    									'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
    							),
    							'messages' => array(
    									\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
    							),
    					),
    			),
    	)));
    	

    	$inputFilter->add($factory->createInput(array(
    			'name'     => 's_saturday',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	
    	 
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 'e_saturday',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 'active_saturday',
    			'required' => false,
    			'validators' => array(
    					array(
    							'name'    => 'InArray',
    							'options' => array(
    									'haystack' => array('0','1'),
    									'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
    							),
    							'messages' => array(
    									\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
    							),
    					),
    			),
    	)));
    	

    	$inputFilter->add($factory->createInput(array(
    			'name'     => 's_sunday',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	
    	 
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 'e_sunday',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 'active_sunday',
    			'required' => false,
    			'validators' => array(
    					array(
    							'name'    => 'InArray',
    							'options' => array(
    									'haystack' => array('0','1'),
    									'strict'   => \Zend\Validator\InArray::COMPARE_STRICT
    							),
    							'messages' => array(
    									\Zend\Validator\InArray::NOT_IN_ARRAY => 'неверное значение".',
    							),
    					),
    			),
    	)));

    	$inputFilter->add($factory->createInput(array(
    			'name'     => 's_shortday',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	 
    	
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 'e_shortday',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));

    	
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 's_regularwd',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	 
    	$inputFilter->add($factory->createInput(array(
    			'name'     => 'e_regularwd',
    			'required' => true,
    			'filters'  => array(
    					array('name' => 'StripTags'),
    					array('name' => 'StringTrim'),
    			),
    			'validators' => array(
    					array(
    							'name'    => 'Regex',
    							'options' => array(
    									'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
    									'messages'=>
    									array(
    											\Zend\Validator\Regex::NOT_MATCH => 'неправильная дата',
    									)
    							),
    					),
    					array(
    							'name' => 'NotEmpty',
    							'options' => array(
    									'messages' => array(
    											\Zend\Validator\NotEmpty::IS_EMPTY => 'дата не может быть пустой',
    									),
    							),
    					),
    			))));
    	 
    	return $this->inputFilter;
    }
}