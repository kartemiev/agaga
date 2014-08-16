<?php
namespace Saas\Media\Form;

use Zend\Form\Form;

class MediaForm extends Form
{
    public function __construct()
    {
        parent::__construct('tempmedia');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        
      
        
        $this->add(array(
             'name' => 'media',
             'attributes' => array(            		
                'id' => 'wtgreeting',
                'type'  => 'file',
                'accept' => 'audio/mpeg, audio/wav'
              		
            ),
            'options' => array(
                 'label_attributes' => array(
                       'class'  => 'bold-label'
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