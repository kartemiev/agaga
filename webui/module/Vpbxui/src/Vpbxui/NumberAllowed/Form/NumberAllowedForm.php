<?php
namespace Vpbxui\NumberAllowed\Form;

use Zend\Form\Form;

class NumberAllowedForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('numbersallowed');
   		$this->setAttribute('id', 'numbersallowed');
   		$this->setAttribute('method', 'put');
   		$this->setAttribute('enctype', 'application/json');
   		 
     	$this->setName('numbersallowed');	
 		$this->setUseInputFilterDefaults(false);
	
 		     $checkbox = $this->add(array(
             'type' => 'MultiCheckbox',
             'name' => 'chk_group',
             'options' => array(
                      'value_options' => array(
                            '100' => '100-199',
                            '200' => '200-299',
                            '300' => '300-399',
                     		'400' => '400-499',
                     		'500' => '500-599',
                     		'600' => '600-699',
                     		'700' => '700-799',
                     		'900' => '900-999',                            		               		 
                     ),
             ),
      ));
 	}
}