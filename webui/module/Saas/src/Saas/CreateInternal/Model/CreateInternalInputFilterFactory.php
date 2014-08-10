<?php
namespace Saas\CreateInternal\Model;

use Zend\InputFilter\Factory as InputFactory;   
use Zend\InputFilter\InputFilter;               

class CreateInternalInputFilterFactory
{
	protected static  $inputFilter;  
	
	public static function getInstance()
	{
		if (!self::$inputFilter)
		{
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();
		 
			$inputFilter->add($factory->createInput(array(
				'name'     => 'extension',
				'required' => true,
				'filters'  => array(
						array('name' => 'Int'),
				),
			)));
			$inputFilter->add($factory->createInput(array(
					'name'     => 'custname',
					'required' => true,					
			)));
			self::$inputFilter = $inputFilter;
		}
		return self::$inputFilter;
	}
}