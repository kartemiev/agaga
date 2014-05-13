<?php
namespace Vpbxui\Offday\Form;

use Zend\Form\Form;
 

class OffdayForm extends Form {

  
    public function __construct($name = null)
    {
    	parent::__construct('offday');
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
    	    'name' => 'name',
    	    'attributes' => array(
    	        'type'  => 'input-small',
     	       'placeholder'=>'ввод...'  
    	    ),
    	    'options' => array(
    	        'label' => 'наименование',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	
    	$this->add(array(
    	    'type' => 'Zend\Form\Element\Date',
    	    'name' => 'rdate',
    	    'attributes' => array(
     	        'min' => date('d/m/Y'),
             'max' => '01/01/2020',
             'step' => '1', // days; default step interval is 1 day
    	    ),
    	    'options' => array(
    	        'label' => 'Дата',    	        
    	    ),
    	));
    	
    	$this->add(array(
    	    'type' => 'Zend\Form\Element\Select',
    	    'name' => 'isworking',
    	    'attributes' =>  array(
    	        'id' => 'isworking',    	    		
    	    	'class'=> 'togglecontainer-control',
       	        'options' => array(
     	            '0' => 'нет', 
     	            '1' => 'да'
     	        ),
    	        'title'=>'является ли рабочим днем',
    	    ),
    	    'options' => array(
    	        'label' => 'рабочий',
    	        'label_attributes' => array(
    	            'class'  => 'bold-label'
    	        ),
    	    ),
    	));
    	
    	 
    	
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Select',
    			'name' => 'cute',
    			'attributes' =>  array(
    			'id' => 'cute',
    					'class'=> 'togglecontainer-exclusive-primary togglecontainer-exclusive',
    					'data-togglecontainer-mutuallyexclusive'=>'apply_specialtime',    					 
    					'title'=>'является ли коротким днем',
    			),
    				'options' => array(
    					'label' => 'короткий',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    					'value_options' => array(
    						  '0' => 'нет',
    	        		      '1' => 'да'
    	
    					),
    					 
    			)
    	));
     
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Select',
    			'name' => 'apply_specialtime',
    			'attributes' =>  array(
    								'id' => 'apply_specialtime',
    				'class'=> 'togglecontainer-control togglecontainer-exclusive',		
    	    		'data-togglecontainer-mutuallyexclusive'=>'cute',    
    					'title'=>'особое время работы',
    					'options' => array(
    							'0' => 'нет',
    							'1' => 'да'
   
    					),
    					'title'=>'особое время работы',
    			),
    			'options' => array(
    					'label' => 'особое время работы',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
	 

    	$this->add(array(
    			'name' => 'start_time',
    			'attributes' =>  array(
    					'id' => 'e_sunday',
    					'data-url'=>'/cabinet/callcentresettings/schedule/date',
    					'class'=>'select2_new',
    					'options' =>
    					array(
    							'undefined'=>''
    					),
    			),
    			'options' => array(
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
     			),
    	)
    	);
    	 
    	 
    	$this->add(array(
    			'name' => 'end_time',
    			'attributes' =>  array(
    					'id' => 'e_sunday',
    					'data-url'=>'/cabinet/callcentresettings/schedule/date',
    					'class'=>'select2_new',
    					'options' =>
    					array(
    							'undefined'=>''
    					),
    			),
    			'options' => array(
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
     			),
    	)
    	);
    	
    	$this->add(array(
    	    'name' => 'comment',
    	    'attributes' => array(
    	        'type'  => 'input-small',
    	        'placeholder'=>'ввод...'
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
