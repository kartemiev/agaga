<?php
namespace Saas\PickDid\Form;

use Zend\Form\Form;

class PickDidForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('pickdid');
		$this->setAttribute('method', 'post');
		
		$this->setAttribute('autocomplete', 'off');
 		$this->setUseInputFilterDefaults(false);
	
 		$this->add(array(
 				'type' => 'Zend\Form\Element\Radio',
 				'name' => 'outgoingtrunk_did',
 				'options' => array(
 						'label' => 'Выберите городской номер',
 						 'value_options' => array(
                             '0' => 'Apple',
                      ),
 				),
 				'attributes'=>
 							array(
 									'class'=>'offset4'				 
 								)
 		));
 		/*
 		$this->add(array(
 				'type' => 'Zend\Form\Element\Button',
  				'name' => 'reload',
 				'options' => array(
 						'label' => 'обновить',
 				),
 				'attributes'=>
 				array(
 						'id' => 'refreshdidsbtn', 							
 						'class'=>'btnaslink'
 				)
 		));
		 */
		$this->add(array(
				'name' => 'submit',
 				'attributes' => array('type' => 'submit', 'value' => 'далее', 'class' => 'primaryAction'),
 		));
		
	}
}