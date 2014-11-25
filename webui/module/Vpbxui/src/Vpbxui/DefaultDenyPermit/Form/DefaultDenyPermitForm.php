<?php
namespace Vpbxui\DefaultDenyPermit\Form;

use Zend\Form\Form;

class DefaultDenyPermitForm extends Form{

    public function __construct($name = null)
    {
     	parent::__construct('defaultdenypermit');
    	$this->setAttribute('method', 'post');
    	$this->setUseInputFilterDefaults(false);
  

     	$this->add(array(
    			'name' => 'deny',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'IP раз.',
    			),
    	));
     	

     	     	$this->add(array(
    			'name' => 'permit',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'IP запр.',
    			),
    	));
     	
    	$this->add(array(
    			'name' => 'submit',
    			'attributes' => array(
    					'type'  => 'submit',
    					'value' => 'Сохранить',
    					'id' => 'submitbutton',
    			),
    	));
    
    	
    }
    
}
