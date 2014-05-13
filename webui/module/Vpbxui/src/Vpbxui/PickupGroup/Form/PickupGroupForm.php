<?php
namespace Vpbxui\PickupGroup\Form;

use Zend\Form\Form;

class PickupGroupForm extends Form{

    public function __construct($name = null)
    {
    	// we want to ignore the name passed
    	parent::__construct('extension');
    	$this->setAttribute('method', 'post');
    	$this->add(array(
    			'name' => 'name',
    			'attributes' => array(
    					'type'  => 'hidden',
    			),
    	));

    	$this->add(array(
    			'name' => 'custname',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Название',
    			),
         ));   
    $this->add(array(
    			'name' => 'description',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Комментарий',
    			),
    	));
       
    	$this->add(array(
    			'name' => 'submit',
    			'attributes' => array(
    					'type'  => 'submit',
    					'value' => 'Go',
    					'id' => 'submitbutton',
    			),
    	));
    }
    
}
