<?php
namespace Vpbxui\FaxUser\Form;

use Zend\Form\Form;

class FaxUserForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('extension');
		$this->setAttribute('method', 'post');
 	
		$this->setAttribute('autocomplete', 'off');
 		$this->setUseInputFilterDefaults(false);
		$this->add(array(
				'name' => 'id',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
	
	 
		$this->add(array(
				'name' => 'custname',
				'attributes' => array(
						'type'  => 'input',
						'title'=>'имя сотрудника',
 				),
				'options' => array(
						'label' => 'имя',
						'label_attributes' => array(
								'class'  => 'bold-label'
						),
				),
		));

		$this->add(array(
				'name' => 'email',
				'attributes' => array(
						'type'  => 'input',
						'title'=>'адрес электронной почты',
				),
				'options' => array(
						'label' => 'e-mail',
						'label_attributes' => array(
								'class'  => 'bold-label'
						),
				),
		));
		
		
		$this->add(array(
				'name' => 'custdesc',
				'attributes' => array(
						'type'  => 'input',
				),
				'options' => array(
						'label' => 'комментарий',
						'label_attributes' => array(
								'class'  => 'bold-label'
						),
				),
		));
	
		$numbers = $this->add(array(
				'type' => 'Zend\Form\Element\Collection',
				'name' => 'emails',
				'options' => array(
 						'count' => 0,
						'should_create_template' => true,
						'template_placeholder' => 'emails',
						'allow_add' => true,
						'target_element' => array(
								'type' => 'Vpbxui\FaxUser\Form\EmailFieldSet'
						),
				)
		));
		 
		$this->add(array(
				'name' => 'submit',
 				'attributes' => array('type' => 'submit', 'value' => 'Go', 'class' => 'primaryAction'),
 		));
		
	}
}