<?php
 namespace Vpbxui\Offday\Form;

use Zend\Form\Form;


class OffdayRangeFilterForm extends Form {


    public function __construct($name = null)
    {
        parent::__construct('offdayrangefilter');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'formsubmit');
         
        $this->setAttribute('autocomplete', 'off');
        $this->setUseInputFilterDefaults(false);

        $currentDate = date('d/m/Y');
          
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'startdate',
            'attributes' => array(
                'class'=>'auto_submit_item',
                'min' => $currentDate,
                'max' => $currentDate,
                'step' => '1', // days; default step interval is 1 day
            ),
            'options' => array(
                'label' => 'с',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'enddate',
             'attributes' => array(
                'class'=>'auto_submit_item',                  
                'min' => $currentDate,
                'max' => $currentDate,
                'step' => '1', // days; default step interval is 1 day
            ),
            'options' => array(
                'label' => 'по',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'itemsperpage',
            'attributes' => array(
                'class'=>'auto_submit_item',
                'options' => array('5'=>'5','10'=>'10','15'=>'15','20'=>'20',
                    '30'=>'30','50'=>'50','100'=>'100','1000'=>'1000','10000'=>'100000'), 
            ),
            'options' => array(
                'label' => 'на странице',
            ),
        ));
         $this->add(array(
            'name' => 'submitbutton',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Показать',
                'id' => 'submitbutton',
            ),
        ));
    }
}
