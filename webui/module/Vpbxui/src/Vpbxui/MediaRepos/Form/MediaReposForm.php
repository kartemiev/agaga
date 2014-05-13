<?php
namespace Vpbxui\MediaRepos\Form;

use Zend\Form\Form;

class MediaReposForm extends Form
{
    public static $mediaClassDebrief = array(
        'ANYMEDIA' => 'любая',        
        'MISICONHOLD' => 'мелодия на удержание',
        'RINGBACKTONE' => 'мелодия звонка',
        'GREETING' => 'приветствие'
     );
    public function __construct()
    {
        parent::__construct('extension');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        
      
        $this->setUseInputFilterDefaults(false);
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'custdesc',
            'attributes' => array(
                'type'  => 'input-small',
                'title' => 'наименование',                
             ),
            'options' => array(
                'label' => ' ',
                'label_attributes' => array(
                    'class'  => 'bold-label'
                ),
            ),
        ));
        
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'mediatype',
            'attributes' =>  array(
                'id' => 'mediatype',
                'class'=>'selectpicker show-tick',                
                'title'=>'категория',
                'options' => self::$mediaClassDebrief,
            ),
            'options' => array(
                 'label_attributes' => array(
                    'class'  => 'bold-label'
                ),
            ),
        ));
                        
        $this->add(array(
             'name' => 'custname',
            'attributes' => array(
                'id' => 'custname',
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