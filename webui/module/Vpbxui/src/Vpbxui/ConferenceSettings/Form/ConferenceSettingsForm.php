<?php
namespace Vpbxui\ConferenceSettings\Form;

use Zend\Form\Form;

class ConferenceSettingsForm extends Form {

    public function __construct($name = null)
    {
     	parent::__construct('conferencesettings');
    	$this->setAttribute('method', 'post');
    	$this->setUseInputFilterDefaults(false);
    	 
 
    	$this->setAttribute('autocomplete', 'off');
     	$this->add(array(
    			'name' => 'deny',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'IP запр',
    			),
    	));
     	
     	$this->add(array(
     	    'name' => 'permit',
     	    'attributes' => array(
     	        'type'  => 'text',
     	    ),
     	    'options' => array(
     	        'label' => 'IP разр',
     	    ),
     	));
     	
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'accesscode',
      			'attributes' =>  array(
     					'id' => 'accesscode',
     					'options' =>
     					array(
     					 '1'=>''
     			),
     			    'disabled' => 'disabled'     			    
     			    
     			),
     			'options' => array(
     					'label' => 'код web авторизации ',
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));

     	 
     	$this->add(array(
     	    'type' => 'Zend\Form\Element\Select',
     	    'name' => 'accessmode',
     	    'attributes' =>  array(
     	        'id' => 'accessmode',
      	        'title'=>'авторизация гостевых пользователей',
     	        'options' => array(
     	            'CODEONLY'=>'только по коду доступа',
     	            'IPONLY'=>'только по IP',
     	            'BOTH'=>'по IP И коду доступа',
     	            'EITHER'=>'по IP ЛИБО коду доступа'
     	        ),
      	    ),
     	    'options' => array(
     	        'label' => 'авторизация',
     	        'label_attributes' => array(
     	            'class'  => 'bold-label'
     	        ),
     	    ),
     	));
     	$this->add(array(
     	    'name' => 'submit',
     	    'attributes' => array(
     	        'type'  => 'submit',
     	        'value' => 'Сохранить',
     	        'id' => 'submitbutton',
     	        'class'=>'btn btn-primary'
     	    ),
     	    'options' => array(
     	        'label' => '&nbsp',
     	        'label_attributes' => array(
     	            'class'  => 'bold-label'
     	        ))
     	));
     	
    	
    	
    }
    
}
