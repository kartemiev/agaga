<?php
namespace Vpbxui\Conference\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;
use Zend\Validator\Regex as RegexValidator;
use Zend\Db\Adapter\AdapterInterface;
 
class Conference implements InputFilterAwareInterface
{  
    public $id;
    public $custname;
    public $custdesc;
    public $confnumber;
    public $ownertype;
    public $ownerref;
    public $isprotected;
    public $pin;
    public $websecret;      
    public $maxmembers;
    public $memberspresent;
    public $datecreated;
    public $datesettoexpiry;
    public $datefirstentered;
    public $createdfrom;
    public $ispstnallowed;
    public $vpbxnum;
    public $lastentered;
    public $joinacl;
    
    public $inputFilter;
    public $dbAdapter;
   
    public function __construct(AdapterInterface $dbAdapter)
    {
    	$this->dbAdapter = $dbAdapter;
    }
	public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->custname = (isset($data['custname'])) ? $data['custname'] : null;
        $this->custdesc = (isset($data['custdesc'])) ? $data['custdesc'] : null;
        $this->confnumber = (isset($data['confnumber'])) ? $data['confnumber'] : null;        
        $this->ownertype = (isset($data['ownertype'])) ? $data['ownertype'] : null;
        $this->ownerref = (isset($data['ownerref'])) ? $data['ownerref'] : null;
        $this->isprotected = (isset($data['isprotected'])) ? $data['isprotected'] : null;
        $this->pin = (isset($data['pin'])) ? $data['pin'] : null;
        $this->websecret = (isset($data['websecret'])) ? $data['websecret'] : null;
        $this->maxmembers = (isset($data['maxmembers'])) ? $data['maxmembers'] : null;
        $this->memberspresent = (isset($data['memberspresent'])) ? $data['memberspresent'] : null;
        $this->datecreated = (isset($data['datecreated'])) ? $data['datecreated'] : null;
        $this->datesettoexpiry = (isset($data['datesettoexpiry'])) ? $data['datesettoexpiry'] : null;
        $this->datefirstentered = (isset($data['datefirstentered'])) ? $data['datefirstentered'] : null;
        $this->createdfrom = (isset($data['createdfrom'])) ? $data['createdfrom'] : null;
        $this->ispstnallowed = (isset($data['ispstnallowed'])) ? $data['ispstnallowed'] : null;
        $this->vpbxnum = (isset($data['vpbxnum'])) ? $data['vpbxnum'] : null;     
        $this->lastentered = (isset($data['lastentered'])) ? $data['lastentered'] : null;      
        $this->joinacl = (isset($data['joinacl'])) ? $data['joinacl'] : null;        
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
          		    'name'     => 'confnumber',
          		    'required' => true,
          		    'filters'  => array(
          		        array('name' => 'Int'),
          		    ),
          		    'validators' => array(
          		        array(
          		            'name'    => 'Digits',
          		            'options' => array(
          		                'messages' =>
          		                array(
          		                    \Zend\Validator\Digits::STRING_EMPTY => 'Номер телеконференции не может быть пустым',
          		                    \Zend\Validator\Digits::NOT_DIGITS => 'Номер телеконференции может состоять только из цифр',
          		                    \Zend\Validator\Digits::INVALID => 'Номер телеконференции номер неверен'
          		                )
          		            ),
          		        ),
          		    	 
          		        array(
          		            'name' => 'NotEmpty',
          		            'options' => array(
          		                'messages' => array(
          		                    \Zend\Validator\NotEmpty::IS_EMPTY => 'Номер телеконференции не может быть пустым.',
          		                ),
          		            ),
          		        ),
          		        array(
          		            'name' => 'Between',
          		            'options' => array(
          		                'min' => 1000,
          		                'max' => 9999,
          		                'messages' =>
          		                array(
          		                    \Zend\Validator\Between::NOT_BETWEEN => 'Номер телеконференции должен лежать в диапазоне от 1000 до 9999',
          		                )          		        
          		            ),
          		        ),
          		    ),
          		)));
          		$inputFilter->add($factory->createInput(array(
          				'name'     => 'reserveduration',
          				'required' => false,
          				'validators' => array(
          						array(
          								'name'    => 'InArray',
          								'options' => array(
          		
          										'haystack' => array('0', '1'),
          										'strict'   => InArray::COMPARE_STRICT,
          										'messages' => array(
          												\Zend\Validator\InArray::NOT_IN_ARRAY => 'задано неверное значение".',
          										),
          								),
          						),
          				),
          		)));
          		$inputFilter->add($factory->createInput(array(
          		    'name'     => 'joinacl',
          		    'required' => false,
          		    'validators' => array(
          		        array(
          		            'name'    => 'InArray',
          		            'options' => array(
          		                
          		                'haystack' => array('ALL', 'INTERNALONLY'),
          		                'strict'   => InArray::COMPARE_STRICT,
          		                'messages' => array(
          		                    \Zend\Validator\InArray::NOT_IN_ARRAY => 'задано неверное значение".',
          		                ),
          		            ),
          		        ),          		                   		        
          		    ),
          		)));
    
          	 
          		$inputFilter->add($factory->createInput(array(
          		    'name'     => 'pin',
          		    'required' => false,
          		    'filters'  => array(
          		        array('name' => 'Int'),
          		    ),
          		    'validators' => array(
          		        array(
          		            'name'    => 'Digits',
          		            'options' => array(
          		                'messages' =>
          		                array(
          		                    \Zend\Validator\Digits::NOT_DIGITS => 'Пин код телефонференции может состоять только из цифр',
          		                    \Zend\Validator\Digits::INVALID => 'Пин код телеконференции номер неверен'
          		                )
          		            ),
          		        ),
          		        array(
          		            'name' => 'Between',
          		            'options' => array(
          		                'min' => 1,
          		                'max' => 9999,
          		                'messages' =>
          		                array(
          		                    \Zend\Validator\Between::NOT_BETWEEN => 'Пин-код может содержать максимум четыре цифры',
          		                )
          		                
          		            ),
          		        ),
          		    ),
          		)));
          		 
          		$this->inputFilter = $inputFilter;
        }
         
        return $this->inputFilter;
    }
    
}
