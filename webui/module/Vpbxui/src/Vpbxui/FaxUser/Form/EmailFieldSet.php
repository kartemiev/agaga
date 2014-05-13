<?php
namespace Vpbxui\FaxUser\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Vpbxui\FaxUserEmail\Model\FaxUserEmail;

class EmailFieldSet extends Fieldset
{
	public function __construct()
	{
		parent::__construct('emails');
		$this->setHydrator(new ClassMethodsHydrator(false))
			 ->setObject(new FaxUserEmail());
		
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
		;
	
		$this->add(array(
				'name' => 'emailsetmarkup',
				'attributes' => array(
						'class' => 'emailsetmarkup',
						'type'  => 'hidden',
				),
		));
	
		$this->add(array(
				'name' => 'deletebutton',
				'attributes' => array(
						'class' => 'deletebutton',
						'type'  => 'button',
						'value'=>'x'
				),
		));
	}
	
	public function getInputFilterSpecification()
	{
		return array(
				'email' => array(
						'required' => true,
				),
		);
	}
}