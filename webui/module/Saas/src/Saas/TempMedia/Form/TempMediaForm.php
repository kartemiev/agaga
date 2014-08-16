<?php
namespace Saas\TempMedia\Form;

use Zend\Form\Form;

class TempMediaForm extends Form
{
    public function __construct()
    {
        parent::__construct('tempmedia');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        
      
        
        $this->add(array(
             'name' => 'wtgreeting',
             'attributes' => array(            		
                'id' => 'wtgreeting',
                'type'  => 'file',
                'accept' => 'audio/mpeg, audio/wav'
              		
            ),
            'options' => array(
                 'label_attributes' => array(
                       'class'  => 'fileupload'
                ),
            ),
        ));
        
        
        $this->add(array(
        		'name' => 'wegreeting',
        		'attributes' => array(
        				'id' => 'wegreeting',
        				'type'  => 'file',
        				'accept' => 'audio/mpeg, audio/wav'
        
        		),
        		'options' => array(
        				'label_attributes' => array(
        						'class'  => 'fileupload'
        				),
        		),
        ));
        
        $this->add(array(
        		'name' => 'ringingbacktone',
        		'attributes' => array(
        				'id' => 'ringingbacktone',
        				'type'  => 'file',
        				'accept' => 'audio/mpeg, audio/wav'
        
        		),
        		'options' => array(
        				'label_attributes' => array(
        						'class'  => 'fileupload'
        				),
        		),
        ));
        
        $this->add(array(
        		'name' => 'musiconhold',
        		'attributes' => array(
        				'id' => 'musiconhold',
        				'type'  => 'file',
        				'accept' => 'audio/mpeg, audio/wav'
        
        		),
        		'options' => array(
        				'label_attributes' => array(
        						'class'  => 'fileupload'
        				),
        		),
        ));
        
        $this->add(array(
        		'name' => 'type',
        		'attributes' => array(
        				'type'  => 'hidden',
        		),
        ));
        
         $this->add(array(
             'name' => 'submit',
             'attributes' => array(
            					'type'  => 'submit',
            					'value' => 'Загрузить',
            					'id' => 'submitbutton',
                 'class'=>'btn btn-primary'
         
             ),
         ));
        
       
    }
}