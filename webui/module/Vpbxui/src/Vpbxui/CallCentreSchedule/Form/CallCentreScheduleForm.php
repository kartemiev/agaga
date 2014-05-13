<?php
namespace Vpbxui\CallCentreSchedule\Form;
 
use Zend\Form\Form;
 
class CallCentreScheduleForm extends Form {

     
    public function __construct($name = null
        )
    {
    	parent::__construct('callcentreschedule');
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
     			'name' => 's_monday',
     			'attributes' =>  array(
    					'id' => 's_monday',
    					'data-url'=>'/cabinet/callcentresettings/schedule/date',
    					'class'=>'select2_new',
       					
    			),
    		 
    	));

    	$this->add(array(
     			'name' => 'e_monday',
    			'attributes' =>  array(
    					'id' => 'e_monday',
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
    	));

    	$this->add(array(
    			'type' => 'Zend\Form\Element\Radio',
    			'name' => 'active_monday',
    			'options' => array(
    					'value_options' => array(
    							1=>'рабочий',
    							0=>'выходной'    		
    					),
    			),
    					 
    			)
    	);
     
     	$this->add(array(
     			'name' => 's_tuesday',
    			'attributes' =>  array(
    					'id' => 's_tuesday',
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
    	));
    	
    	$this->add(array(
     			'name' => 'e_tuesday',
    			'attributes' =>  array(
    					'id' => 'e_tuesday',
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
    	));
    	
    	 
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Radio',
    			'name' => 'active_tuesday',
    			'options' => array(
    					'value_options' => array(
    							1=>'рабочий',
    							0=>'выходной'    		
    					),
    			),
    					 
    			)
    	);
    	 

    	$this->add(array(
     			'name' => 's_wednesday',
    			'attributes' =>  array(
    					'id' => 's_wednesday',
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
    	));
    	 
    	$this->add(array(
     			'name' => 'e_wednesday',
    			'attributes' =>  array(    					
    					'id' => 'e_wednesday',
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
    	));
    	 
    	
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Radio',
    			'name' => 'active_wednesday',
    			'options' => array(
    					'value_options' => array(
    							1=>'рабочий',
    							0=>'выходной'    		
    					),
    			),
    					 
    			)
    	);
    	
    	$this->add(array(
     			'name' => 's_thursday',
    			'attributes' =>  array(
    					'id' => 's_thursday',
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
    	));
    	
    	$this->add(array(
     			'name' => 'e_thursday',
    			'attributes' =>  array(
    					'id' => 'e_thursday',
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
    	));
    	
    	 
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Radio',
    			'name' => 'active_thursday',
    			'options' => array(
    					'value_options' => array(
    							1=>'рабочий',
    							0=>'выходной'    		
    					),
    			),
    					 
    			)
    	);
    	
    	
    	$this->add(array(
     			'name' => 's_friday',
    			'attributes' =>  array(    					
    					'id' => 's_friday',
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
    	));
    	 
    	$this->add(array(
     			'name' => 'e_friday',
    			'attributes' =>  array(
    					'id' => 'e_friday',
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
    	));
    	 
    	
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Radio',
    			'name' => 'active_friday',
    			'options' => array(
    					'value_options' => array(
    							1=>'рабочий',
    							0=>'выходной'    		
    					),
    			),
    					 
    			)
    	);
    	
    	
    	$this->add(array(
     			'name' => 's_saturday',
    			'attributes' =>  array(
    					'id' => 's_saturday',
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
    	));
    	
    	$this->add(array(
     			'name' => 'e_saturday',
    			'attributes' =>  array(
    					'id' => 'e_saturday',
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
    	));
    	
    	 
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Radio',
    			'name' => 'active_saturday',
    			'options' => array(
    					'value_options' => array(
    							1=>'рабочий',
    							0=>'выходной'    		
    					),
    			),
    					 
    			)
    	);
    	 
    	
    	$this->add(array(
     			'name' => 's_sunday',
    			'attributes' =>  array(
    					'id' => 's_sunday',
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
    	));
    	 
    	$this->add(array(
     			'name' => 'e_sunday',
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
    			'type' => 'Zend\Form\Element\Radio',
    			'name' => 'active_sunday',
    			'options' => array(
    					'value_options' => array(
    							1=>'рабочий',
    							0=>'выходной'    		
    					),
    			),
    					 
    			)
    	);
    	
    	

    	$this->add(array(
    			'name' => 's_shortday',
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
    			'name' => 'e_shortday',
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
    			'name' => 's_regularwd',
    			'attributes' =>  array(
    					'id' => 's_regularwd',
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
    			'name' => 'e_regularwd',
    			'attributes' =>  array(
    					'id' => 'e_regularwd',
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
           'name' => 'submit',
            'attributes' => array('type' => 'submit', 'value' => 'Go', 'class' => 'primaryAction'),
        ));
     }
 
 }
 

