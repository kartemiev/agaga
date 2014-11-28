<?php
namespace Vpbxui\ConferenceSettings\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
use Zend\Validator\InArray;
 
class ConferenceSettings implements InputFilterAwareInterface
{
    public $deny;
    public $permit;    
    public $accesscode;
    public $accessmode;
    private  $inputFilter;
   
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function exchangeArray($data)
    {
        $this->deny = (isset($data['deny'])) ? $data['deny'] : null;
        $this->permit = (isset($data['permit'])) ? $data['permit'] : null;
        $this->accesscode = (isset($data['accesscode'])) ? $data['accesscode'] : null;
        $this->accessmode = (isset($data['accessmode'])) ? $data['accessmode'] : null;
        
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
                'name'     => 'deny',
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
                            'max'      => 512,
                            'messages' =>
                            array(
                                \Zend\Validator\StringLength::TOO_SHORT => 'Неверная длина поля ввода',
                                \Zend\Validator\StringLength::TOO_LONG => 'Неверная длина поля ввода',
                                \Zend\Validator\StringLength::INVALID => 'Неверные символы в поле ввода',
                            )
                        ),
                    ),
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Поле не может быть пустым".',
                            ),
                        ),
                    ),
                ),
            )));
                 $inputFilter->add($factory->createInput(array(
                    'name'     => 'permit',
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
                                'max'      => 512,
                                'messages' =>
                                array(
                                    \Zend\Validator\StringLength::TOO_SHORT => 'Неверная длина поля ввода',
                                    \Zend\Validator\StringLength::TOO_LONG => 'Неверная длина поля ввода',
                                    \Zend\Validator\StringLength::INVALID => 'Неверные символы в поле ввода',
                                )
                            ),
                        ),
                        array(
                            'name' => 'NotEmpty',
                            'options' => array(
                                'messages' => array(
                                    \Zend\Validator\NotEmpty::IS_EMPTY => 'Поле не может быть пустым".',
                                ),
                            ),
                        ),
                    ),
                )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'accessmode',
                'required' => false,
                'validators' => array(
              						array(
              						    'name'    => 'InArray',
              						    'options' => array(
    
              						        'haystack' => array('IPONLY','CODEONLY','BOTH','EITHER'),
              						        'strict'   => InArray::COMPARE_STRICT,
              						        'messages' => array(
              						            \Zend\Validator\InArray::NOT_IN_ARRAY => 'задано неверное значение".',
              						        ),
              						    ),
              						),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'accesscode',
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