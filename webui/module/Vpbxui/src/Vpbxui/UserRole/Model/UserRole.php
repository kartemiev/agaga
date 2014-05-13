<?php
namespace Vpbxui\UserRole\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
 use Zend\Db\Adapter\AdapterInterface;

class UserRole implements InputFilterAwareInterface
{
    public $user_id;
    public $role;
    public $username;
    public $email;
    public $description;
    
    protected  $dbAdapter;
    protected $inputFilter;                       // <-- Add this variable
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function exchangeArray($data)
    {
        $this->user_id     = (isset($data['user_id'])) ? $data['user_id'] : null; 
        $this->role     = (isset($data['role'])) ? $data['role'] : null;
        $this->username     = (isset($data['username'])) ? $data['username'] : null;
        $this->email     = (isset($data['email'])) ? $data['email'] : null;
        $this->description     = (isset($data['description'])) ? $data['description'] : null;
        
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
                'name'     => 'user_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
   
          		$inputFilter->add($factory->createInput(array(
          		    'name'     => 'role',
          		    'required' => true,
          		    'validators' => array(
          		        array(
          		            'name'    => 'Zend\Validator\Db\RecordExists',
          		            'options' => array(
          		                'adapter' => $dbAdapter,
          		                'table' => 'user_role',
          		                'field'   => 'role_id',
          		                'messages' => array(
          		                    \Zend\Validator\Db\RecordExists::ERROR_NO_RECORD_FOUND => 'такой роли не существует".',
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