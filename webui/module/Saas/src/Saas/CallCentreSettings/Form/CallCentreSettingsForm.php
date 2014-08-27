<?php
namespace Saas\CallCentreSettings\Form;

use Zend\Form\Form;
class CallCentreSettingsForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('ccsettings');
		$this->setAttribute('method', 'post');
		$this->setAttribute('autocomplete', 'off');
 	
		$this->setUseInputFilterDefaults(false);
	
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'schedule',
				'options' => array(
						'label'=>'расписание работы колл-центра',
						'value_options' => array(
								'0' => 'Пн-Пт 10:00-19:00; Сб-Вс - выходной',
								'1' => 'Пн-Пт 09:00-18:00; Сб-Вс - выходной',
								'2' => 'Пн-Пт 09:30-18:30; Сб-Вс - выходной',
								'3' => '24 часа в сутки, 7 дней в неделю',
								'4' => 'другой',							
						),
				),
 		));
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'delay',
				'options' => array(
						'label'=>'задержка перед направлением вызова в колл-центр (время для донабора номера)',
						'value_options' => array(
								'0' => '',
						),
				),
		));
		
		
	}
}