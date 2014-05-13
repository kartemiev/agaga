<?php
namespace Vpbxui\Ivr\Form;

use Zend\Form\Form;
  
class IvrForm extends Form
{
	protected $extensionTable;
	protected $ivrTable;
	public function __construct($name = null)
	{
		parent::__construct('context');
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
						'type'  => 'text',
				),
				'options' => array(
						'label' => 'название',
				),
		));
	 
	
		$this->add(array(
				'name' => 'custdesc',
				'attributes' => array(
						'type'  => 'textarea',
				),
				'options' => array(
						'label' => 'комментарий',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Go',
						'id' => 'submitbutton',
				),
		));
		
	}
	
 
}