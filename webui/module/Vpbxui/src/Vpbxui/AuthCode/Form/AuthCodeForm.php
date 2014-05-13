<?php
namespace Vpbxui\AuthCode\Form;
 
use Zend\Form\Form;
 
class AuthCodeForm extends Form {

     
    public function __construct($name = null
        )
    {
    	parent::__construct('authcode');
    	$this->setAttribute('method', 'post');
    	 
    	$this->setAttribute('autocomplete', 'off');
    	$this->setUseInputFilterDefaults(false);
    	 
    	$this->add(array(
    			'name' => 'vpbx_id',    			
    			'attributes' => array(
    					'type'  => 'hidden',
    			),
    	));
    	$this->add(array(
           'name' => 'pincode',
           'attributes' => array(
               'id' =>'pincode',
               'type'  => 'text',
                'title'=>'PIN код доступа',                
           ),
           'options' => array(
               'label' => 'PIN код',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
    	
       
       $this->add(array(
           'name' => 'submit',
            'attributes' => array('type' => 'submit', 'value' => 'Go', 'class' => 'primaryAction'),
        ));
     }
 
 }
 

