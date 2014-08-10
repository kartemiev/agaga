<?php
namespace Saas\CreateInternal\Form;

use Zend\Form\Form;

class CreateInternalForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('intlist');
		$this->setAttribute('method', 'post');		
		$this->setAttribute('autocomplete', 'off');
		$this->setAttribute('class', 'intlist');
		
 		$this->setUseInputFilterDefaults(false);
	
 		 $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'number',
             'options' => array(
                     'value_options' => array(
                             '0' => '',
                     ),
             ), 	  		 	
     ));
 		
	}
}