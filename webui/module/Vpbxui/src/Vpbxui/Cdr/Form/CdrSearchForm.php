<?php
 namespace Vpbxui\Cdr\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\Validator\Regex as RegexValidator;

class CdrSearchForm extends Form implements InputFilterAwareInterface {


    public function __construct($name = null)
    {
        parent::__construct('cdrsearchform,');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'formsubmit');
         
        $this->setAttribute('autocomplete', 'off');
        $this->setUseInputFilterDefaults(false);

        $currentDate = date('d/m/Y');
          
        $this->add(array(
            'name' => 'startdate',
            'attributes' => array(
                 'data-url'=>'/cabinet/cdr/fetch',
            	'class'=>'select2',
            	'placeholder'=>'введите дату "с"',
            	'title'=> 'даты вызовов начала поиска',             		            		
            ),
             
        ));
        $this->add(array(
             'name' => 'enddate',
             'attributes' => array(
                 'data-url'=>'/cabinet/cdr/fetch',
            	'class'=>'select2',
            	'placeholder'=>'введите дату "по"',
        		'title'=> 'даты вызовов окончания поиска',             		        				
            ),
             
        ));
        
        $this->add(array(
        		'name' => 'calldest', 
        		'attributes' => array(
        				'data-url'=>'/cabinet/cdr/fetch',
        				'class'=>'select2',
        				'placeholder'=>'введите номер абонента',
        				'title'=> 'номер абонента'             		        				
        		),
        ));
        
        $this->add(array(
        		'name' => 'callerid',
        		'attributes' => array(
        				'data-url'=>'/cabinet/cdr/fetch',
        				'class'=>'select2',
        				'placeholder'=>'введите АОН',
        				'title'=> 'АОН абонента',             		        				        				
        		),
        ));
        
         $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'calldirection',
        		'attributes' =>  array(
        				'id' => 'routeref',
        				'options' => array(
        						'ALL'=>'все',
        						'INCOMING'=>'входящие',
        						'OUTGOING'=>'исходящие'
        				),
        				'title'=> 'направление вызова',        				
        		),
        		'options' => array(
         				'label_attributes' => array(
        						'class'  => 'bold-label'
        				),
        		),
        ));
          $this->add(array(
             'type' => 'Zend\Form\Element\Radio',
             'name' => 'onlyrecorded',
             'options' => array(
                              '0' => 'все',
                             '1' => 'записанные',
              				 '2' => 'пропущенные - колл-центр'
              				            		
             )
     ));
          
      
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'itemsperpage',
            'attributes' => array(
                'class'=>'auto_submit_item',
                'options' => array('5'=>'5','10'=>'10','20'=>'20',
                   '50'=>'50','100'=>'100','1000'=>'1000','10000'=>'10000'), 
            	'value'=>'50'
            ),
            'options' => array(
                'label' => 'отображать',            	
             ),
         ));
         $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Поиск',
                'id' => 'submitbutton',
            ),
        ));

         
    }
 
}