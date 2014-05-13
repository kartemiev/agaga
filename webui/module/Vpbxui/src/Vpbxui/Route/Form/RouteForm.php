<?php
namespace Vpbxui\Route\Form;

use Zend\Form\Form;
use Vpbxui\Route\Form\RouteDestinationFieldset;

class RouteForm extends Form {
   
    public function __construct(RouteDestinationFieldset $routeDestinationFieldset)
    {
    	parent::__construct('route');
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
    	        'title'=>'Название'
    	    ),
    	    'options' => array(
    	        'label' => 'название',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Select',
    			'name' => 'isdefault',
    			'attributes' =>  array(
    					'id' => 'isdefault',
    					'options' => array(false=>'нет', true=>'да'),
    			),
    			'options' => array(
    					'label' => 'маршрут по умолчанию',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
       $numbers = $this->add(array(
       		'type' => 'Zend\Form\Element\Collection',
       		'name' => 'destinations',
       		'options' => array(
       				'count' => 1,
       				'should_create_template' => true,
       				'template_placeholder' => 'markupplaceholder', 
       				'allow_add' => true,
       				'target_element' => $routeDestinationFieldset
        		)
       ));

       $this->add(array(
       		'name' => 'custdesc',
       		'attributes' => array(
       				'type'  => 'textarea'
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
