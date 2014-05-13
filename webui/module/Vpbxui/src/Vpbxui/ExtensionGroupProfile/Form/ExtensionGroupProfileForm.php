<?php
namespace Vpbxui\ExtensionGroupProfile\Form;

use Zend\Form\Form;

class ExtensionGroupProfileForm extends Form{

    public function __construct($name = null)
    {
    	// we want to ignore the name passed
    	parent::__construct('extensiongroupprofile');
    	$this->setAttribute('method', 'post');
    	$this->add(array(
    			'name' => 'id',
    			'attributes' => array(
    					'type'  => 'hidden',
    			),
    	));

     	$this->add(array(
    			'name' => 'profilename',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Название профиля группы',
    			),
    	));
     	
     	$this->add(array(
     	    'name' => 'profiledesc',
     	    'attributes' => array(
     	        'type'  => 'textarea',
     	    ),
     	    'options' => array(
     	        'label' => 'Комментарий профиля группы',
     	    ),
     	));
     	
     	$this->add(array(
     	    'type' => 'Zend\Form\Element\Select',
     	    'name' => 'transfer',
     	    'attributes' =>  array(
     	        'id' => 'transfer',
     	        'options' => array(
      	            'allowed' => 'разрешен',
     	            'forbidden' => 'запрещен',
     	        ),
     	    ),
     	    'options' => array(
     	        'label' => 'Перевод вызова',
     	    ),
     	));
     	$this->add(array(
     	    'type' => 'Zend\Form\Element\Select',
     	    'name' => 'statuschange',
     	    'attributes' =>  array(
     	        'id' => 'statuschange',
     	        'options' => array(
      	            'allowed' => 'разрешено',
     	            'forbidden' => 'запрещено',
     	        ),
     	    ),
     	    'options' => array(
     	        'label' => 'Изменение статуса',
     	    ),
     	));

     	$this->add(array(
     	    'type' => 'Zend\Form\Element\Select',
     	    'name' => 'incoming',
     	    'attributes' =>  array(
     	        'id' => 'incoming',
     	        'options' => array(
      	            'allowed' => 'разрешен',
     	            'forbidden' => 'запрещен',
     	        ),
     	    ),
     	    'options' => array(
     	        'label' => 'Прием входящих вызовов',
     	    ),
     	));
     	
     	$this->add(array(
     	    'type' => 'Zend\Form\Element\Select',
     	    'name' => 'memberofcallcentreque',
     	    'attributes' =>  array(
     	        'id' => 'memberofcallcentreque',
     	        'options' => array(
      	            'true' => 'да',
     	            'false' => 'нет',
     	        ),
     	    ),
     	    'options' => array(
     	        'label' => 'Является участником очереди колл-центра на прием звонков',
     	    ),
     	));
     	
     	$this->add(array(
     	    'type' => 'Zend\Form\Element\Select',
     	    'name' => 'hold',
     	    'attributes' =>  array(
     	        'id' => 'hold',
     	        'options' => array(
      	            'allowed' => 'разрешено',
     	            'forbidden' => 'запрещено',
     	        ),
     	    ),
     	    'options' => array(
     	        'label' => 'Удержание вызова',
     	    ),
     	));

     	$this->add(array(
     	    'type' => 'Zend\Form\Element\Select',
     	    'name' => 'forwarding',
     	    'attributes' =>  array(
     	        'id' => 'forwarding',
     	        'options' => array(
      	            'allowed' => 'разрешена',
     	            'forbidden' => 'запрещена',
     	        ),
     	    ),
     	    'options' => array(
     	        'label' => 'Переадресация вызова',
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
