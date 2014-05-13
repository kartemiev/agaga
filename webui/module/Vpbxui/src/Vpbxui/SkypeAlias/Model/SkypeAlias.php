<?php
namespace Vpbxui\SkypeAlias\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\Regex as RegexValidator;
use Zend\Db\Adapter\AdapterInterface;

class SkypeAlias implements InputFilterAwareInterface
{
    public $id;
    public $number;
    public $skypeid;
   	public $custname;
   	public $custdesc;
    
    protected  $dbAdapter;    
    protected $inputFilter;  

    public function __construct($adapter)
    {
        $this->dbAdapter = $adapter;
    }
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;        
        $this->number     = (isset($data['number'])) ? $data['number'] : null;
        $this->skypeid     = (isset($data['skypeid'])) ? $data['skypeid'] : null;    
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;
        
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
     				'name'     => 'id',
     				'required' => true,
     				'filters'  => array(
     						array('name' => 'Int'),
     				),
     		)));
     		

     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'custname',
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
     				'name'     => 'number',
     				'required' => true,
     				'filters'  => array(
     						array('name' => 'int'),
     				),
      		    'validators' => array(
      		        array(
      		            'name'    => 'Digits',
      		            'options' => array(
      		                'messages' =>
      		                array(
      		                    \Zend\Validator\Digits::STRING_EMPTY => 'Поле внутреннего номера не может быть пустым',
      		                    \Zend\Validator\Digits::NOT_DIGITS => 'Внутренний номер может состоять только из цифр',
      		                    \Zend\Validator\Digits::INVALID => 'Внутренний номер неверен'
      		                )
      		            ),
      		        ),
      		    	array(
      		    		'name' => 'Zend\Validator\Db\NoRecordExists',
      		    			'options' => array(
      		    			'table' => 'skype_aliases',
      		    			'field' => 'number',      		    		 
      		    			'adapter' => $this->dbAdapter,	
      		    			'messages' =>
      		    					array(
      		    							\Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'Номер алиаса уже занят',
      		    					)
      					)      		    			      		    		 
      				),
      		    		array(
      		    				'name'    => 'Between',
      		    				'options' => array(
       		    						'min'      => 1000,
      		    						'max'      => 9999,
      		    						'messages' =>
      		    						array(
      		    								\Zend\Validator\Between::NOT_BETWEEN   => 'Номер должен состоять из 4 цифр'
      		    						)
      		    				),
      		    				 
      		    		),
      		        array(
      		            'name' => 'NotEmpty',
      		            'options' => array(
      		                'messages' => array(
      		                    \Zend\Validator\NotEmpty::IS_EMPTY => 'Поле внутреннего номера не может быть пустым".',
      		                ),
      		            ),
      		        ),      		        
      		    ),
     		)));
      		

                     		$inputFilter->add($factory->createInput(array(
     				'name'     => 'skypeid',
     				'required' => false,
     				'filters'  => array(
     						array('name' => 'StripTags'),
     						array('name' => 'StringTrim'),
     				),
     				'validators' => array(
     						array(
     								'name'    => 'Regex',
      								'options' => array(
                                                              'messages' => array(
                                           RegexValidator:: NOT_MATCH =>
   'имя учетной записи Skype может содержать только латинские только латинские буквы, цифры и пробел (от 5 до 60 символов)'                         
                                                                  ),

                                                                'pattern' => '/^[\w\-_]{5,60}$/'
     								 
     								),
     						),
     				))));              
     		
                     		
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
                     										'max'      => 100,
                     								),
                     						),
                     				))));
     		$this->inputFilter = $inputFilter;
     	}
     
     	return $this->inputFilter;
     }
 }
