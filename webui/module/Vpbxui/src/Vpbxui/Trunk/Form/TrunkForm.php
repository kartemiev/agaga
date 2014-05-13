<?php
namespace Vpbxui\Trunk\Form;

use Zend\Form\Form;

class TrunkForm extends Form
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
    					'title'=>'Название',
    					'placeholder'=>'ввод...'
    			),
    			'options' => array(
    					'label' => 'название',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	$this->add(array(
    			'name' => 'callerid',
    			'attributes' => array(
    					'type'  => 'input',
    			),
    			'options' => array(
    					'label' => 'исходящий АОН',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	$this->add(array(
    			'name' => 'name',
    			'attributes' => array(
    					'type'  => 'input',
    			),
    			'options' => array(
    					'label' => 'имя регистрации',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	$this->add(array(
    			'name' => 'host',
    			'attributes' => array(
    					'type'  => 'input',
    			),
    			'options' => array(
    					'label' => 'имя сервера',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	$this->add(array(
    			'name' => 'port',
    			'attributes' => array(
    					'type'  => 'input',
    			),
    			'options' => array(
    					'label' => 'порт',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));    	
    	$this->add(array(
    			'name' => 'secret',
    			'attributes' => array(
    					'type'  => 'password',
    			),
    			'options' => array(
    					'label' => 'пароль',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	$this->add(array(
    			'name' => 'insecure',
    			'attributes' => array(
    					'type'  => 'input',
    			),
    			'options' => array(
    					'label' => 'тип аутентификации',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	$this->add(array(
    			'name' => 'callbackextension',
    			'attributes' => array(
    					'type'  => 'input',
    			),
    			'options' => array(
    					'label' => 'callbackextension',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	$this->add(array(
    			'name' => 'custdesc',
    			'attributes' => array(
    					'title'=> 'комментарий для внутреннего пользования',
    					'type'  => 'input-small',
    					'placeholder' => 'ввод...'
    			),
    			'options' => array(
    					'label' => 'комментарий',
    					'label_attributes' => array(
    							'class'  => 'bold-label'
    					),
    			),
    	));
    	 
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Csrf',
    			'name' => 'csrf',
    			'options' => array(
    					'csrf_options' => array(
    							'timeout' => 600
    					)
    			)
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