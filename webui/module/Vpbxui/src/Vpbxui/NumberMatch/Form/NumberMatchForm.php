<?php
namespace Vpbxui\NumberMatch\Form;

use Zend\Form\Form;
 

class NumberMatchForm extends Form {

  
    public function __construct($name = null)
    {
    	parent::__construct('numbermatch');
    	$this->setAttribute('method', 'post');
     	 
    	$this->setAttribute('autocomplete', 'off');
     	$this->setUseInputFilterDefaults(false);

    	$this->add(array(
    			'name' => 'id',
    			'attributes' => array(
    					'type'  => 'hidden',
    			),
    	));
     
    	$this->add(array(
    			'name' => 'custname',
    			'attributes' => array(
    					'type'  => 'input',
    			),
    			'options' => array(
    					'label' => 'название',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	 
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Collection',
    			'name' => 'regentries',
    			'options' => array(
     					'count' => 1,
    					'should_create_template' => true,
    					'template_placeholder' => 'markupplaceholder',
    					'allow_add' => true,
    					'target_element' => array(
    							'type'=>'Vpbxui\NumberMatch\Form\RegEntryFieldset'
    							),
    			)
    	));
    		
    	$this->add(array(
    			'name' => 'custdesc',
    			'attributes' => array(
    					'type'  => 'textarea',
    			),
    			'options' => array(
    					'label' => 'комментарий',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
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
