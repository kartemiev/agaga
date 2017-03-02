<?php
namespace Vpbxui\ExtensionGroup\Form;

use Zend\Form\Form;

class ExtensionGroupForm extends Form{

    public function __construct($name = null)
    {
    	// we want to ignore the name passed
    	parent::__construct('extensiongroup');
    	$this->setAttribute('method', 'post');
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
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Название',
    			),
    	));
     	
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'number_status',
     			'attributes' =>  array(
     					'id' => 'number_status',
     					'options' =>
     					array(
     							'UNDEFINED'=>'',
     							'ACTIVE'=>'отсутствует',
     							'SUSPENDED'=>'временно заблокирован'
     					),
     			),
     			'options' => array(
     					'label' => 'блокировка',
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
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
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'extensionrecord',
     			'attributes' =>  array(
     					'id' => 'extensionrecord',
     					'options' => array(
     							'undefined'=> '',     							
     							'active' => 'включена',
     							'disabled' => 'выключена',
     					),
     			),
     			'options' => array(
     					'label' => 'запись переговоров',
     			),
     			
      ));
     	
     	$this->add(array(
     	    'type' => 'Zend\Form\Element\Select',
     	    'name' => 'vmdiversion',
     	    'attributes' =>  array(
     	        'id' => 'vmdiversion',
     	        'options' => array(
     	            '1' => 'включено',
     	            '0' => 'отключено',
     	        ),
     	    ),
     	    'options' => array(
     	        'label'=> 'направление на голосовую почту',
     	        'label_attributes' => array(
     	            'class'  => 'bold-label'
     	        ),
     	    ),
     	));
     	
     	
     	
     	$this->add(array(
     	    'name' => 'vmtimeout',
     	    'attributes' => array(
     	        'id' => 'vmtimeout',
     	        'type'  => 'number',
     	    ),
     	    'options' => array(
     	        'label' => 'преадресация на голосовую почту через, сек',
     	        'label_attributes' => array(
     	            'class'  => 'bold-label'
     	        ),
     	    ),
     	));
     	
     	

     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'diversion_unconditional_status',
     			'attributes' =>  array(
     					'id' => 'diversion_unconditional_status',
     					'options' => array('UNDEFINED'=>'', 'ACTIVATED'=>'активна', 'DEACTIVATED'=>'неактивна'),
     			),
     			'options' => array(
     					'label' => 'безусловная',
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));
     	
     	
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'diversion_unconditional_landingtype',
     			'attributes' =>  array(
     					'id' => 'diversion_unconditional_landingtype',
     					'class'=> 'subfieldsetshuffle-control',
     					'options' => array('NUMBER'=>'номер', 'VOICEMAIL'=>'голосовая почта', 'FAX'=>'факс'),
     			),
     			'options' => array(
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));
     	 
     	 
     	$this->add(array(
     			'name' => 'diversion_unconditional_number',
     			'attributes' => array(
     					'type'  => 'text',
     					'class'=> 'subfieldsetshuffle-data',
     					'data-value'=> 'NUMBER',
     					//'placeholder'=> 'номер...',
     			),
     	));
     	
     	 
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'diversion_unavail_status',
     			'attributes' =>  array(
     					'id' => 'diversion_unavail_status',
     					'options' => array('UNDEFINED'=>'', 'ACTIVATED'=>'активна', 'DEACTIVATED'=>'неактивна'),
     			),
     			'options' => array(
     					'label' => 'отключен',
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));
     	
     	 
     	
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'diversion_unavail_landingtype',
     			'attributes' =>  array(
     					'id' => 'diversion_unavail_landingtype',
     					'class'=> 'subfieldsetshuffle-control',
     					'options' => array('NUMBER'=>'номер', 'VOICEMAIL'=>'голосовая почта', 'FAX'=>'факс'),
     			),
     			'options' => array(
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));
     	
     	 
     	$this->add(array(
     			'name' => 'diversion_unavail_number',
     			'attributes' => array(
     					'type'  => 'text',
     					'class'=> 'subfieldsetshuffle-data',
     					'data-value'=> 'NUMBER',
     					//		'placeholder'=> 'номер...',
     			),
     	));
     	
     	 
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'diversion_busy_status',
     			'attributes' =>  array(
     					'id' => 'diversion_busy_status',
     					'options' => array('UNDEFINED'=>'', 'ACTIVATED'=>'активна', 'DEACTIVATED'=>'неактивна'),
     			),
     			'options' => array(
     					'label' => 'занято',
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));
     	 
     	
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'diversion_busy_landingtype',
     			'attributes' =>  array(
     					'id' => 'diversion_busy_landingtype',
     					'class'=> 'subfieldsetshuffle-control',
     					'options' => array('NUMBER'=>'номер', 'VOICEMAIL'=>'голосовая почта', 'FAX'=>'факс'),
     			),
     			'options' => array(
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));
     	 
     	$this->add(array(
     			'name' => 'diversion_busy_number',
     			'attributes' => array(
     					'type'  => 'text',
     					'class'=> 'subfieldsetshuffle-data',
     					'data-value'=> 'NUMBER',
     					//	'placeholder'=> 'номер...',
     			),
     	));
     	 
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'diversion_noanswer_status',
     			'attributes' =>  array(
     					'id' => 'diversion_noanswer_status',
     					'options' => array('UNDEFINED'=>'', 'ACTIVATED'=>'активна', 'DEACTIVATED'=>'неактивна'),
     			),
     			'options' => array(
     					'label' => 'неответ',
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));
     	 
     	$this->add(array(
     			'type' => 'Zend\Form\Element\Select',
     			'name' => 'diversion_noanswer_landingtype',
     			'attributes' =>  array(
     					'id' => 'diversion_noanswer_landingtype',
     					'class'=> 'subfieldsetshuffle-control',
     					'options' => array('NUMBER'=>'номер', 'VOICEMAIL'=>'голосовая почта', 'FAX'=>'факс'),
     			),
     			'options' => array(
     					'label_attributes' => array(
     							'class'  => 'bold-label'
     					),
     			),
     	));
     	 
     	$this->add(array(
     			'name' => 'diversion_noanswer_number',
     			'attributes' => array(
     					'type'  => 'text',
     					'class'=> 'subfieldsetshuffle-data',
     					//'placeholder'=> 'номер...',
     					'data-value'=> 'NUMBER',
     			),
     	));
     	 
     	$this->add(array(
     			'name' => 'diversion_noanswer_duration',
     			'attributes' => array(
     					'type'  => 'text',
     					'class'=>"slider",
     					'data-slider-min'=>"0",
     					'data-slider-max'=>"60",
     					'data-slider-step'=>"1",
     					'data-slider-orientation'=>"horizontal",
     					'data-slider-selection'=>"before",
     					'data-slider-handle'=>'triangle'
     			),
     	
     	));
     	
     	
     	
     	$this->add(array(
     	    'name' => 'custdesc',
     	    'attributes' => array(
     	        'type'  => 'textarea',
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
