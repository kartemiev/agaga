<?php
namespace Vpbxui\Context\Form;

use Zend\Form\Form;
use Vpbxui\Ivr\Model\IvrTableInterface;
use Vpbxui\Extension\Model\ExtensionTableInterface;
use Vpbxui\Context\Form\TrunkFieldset;
use Vpbxui\Feature\Model\FeatureTableInterface;

class ContextForm extends Form
{
	protected $extensionTable;
	protected $ivrTable;
	protected $trunkFieldset;
	protected $featuresTable;
	public function __construct($name = null, 
			ExtensionTableInterface $extensionTable, 
			IvrTableInterface $ivrTable, 
			TrunkFieldset $trunkFieldset,
			FeatureTableInterface $featuresTable
			)
	{
		$this->extensionTable = $extensionTable;
		$this->ivrTable = $ivrTable;
		$this->trunkFieldset = $trunkFieldset;
		$this->featuresTable = $featuresTable;
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
       		'type' => 'Zend\Form\Element\Collection',
       		'name' => 'trunks',
       		'options' => array(
       		//		'label' => 'Выберите номера на которые будут направлены вызовы',
       				'count' => 0,
       				'should_create_template' => true,
       				'template_placeholder' => 'markupplaceholder', 
       				'allow_add' => true,
       				'target_element' => $this->trunkFieldset,
        		)
       ));
		 
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'contexttype',
				'attributes' =>  array(
						'id' => 'contexttype',
						'class'=> 'subfieldsetshuffle-control',						
						'options' => array(
				    		'IVR'=> 'IVR',
							'EXTENSION' => 'внутренний номер',
							'FUNCTION' => 'специальные функции'								
						),
				),
				'options' => array(
						'label' => 'направление вызова',
						'label_attributes' => array(
								'class'  => 'bold-label'
						),
				),
		));
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'internalref',
				'attributes' =>  array(
						'id' => 'internalref',
						'class'=> 'subfieldsetshuffle-data',	
						'data-value'=> 'EXTENSION',					
						'options' => $this->getInputListOptions($extensionTable, 'extension'),
				),
				'options' => array(
 						'label_attributes' => array(
								'class'  => 'bold-label'
						),
				),
		));
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'ivrref',
				'attributes' =>  array(
						'id' => 'ivrref',
						'data-value'=> 'IVR',						
						'class'=> 'subfieldsetshuffle-data',						
						'options' => $this->getInputListOptions($ivrTable, 'custname'),
				),
				'options' => array(
 						'label_attributes' => array(
								'class'  => 'bold-label'
						),
				),
		));
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'funcref',
				'attributes' =>  array(
						'id' => 'funcref',
						'data-value'=> 'FUNCTION',
						'class'=> 'subfieldsetshuffle-data',
						'options' => $this->getInputListOptions($featuresTable, 'custname'),
				),
				'options' => array(
						'label_attributes' => array(
								'class'  => 'bold-label'
						),
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
	
	protected function getInputListOptions($table, $textFieldName)
	{
		$result = array();
		$entries = $table->fetchAll();
		foreach ($entries as $entry)
		{
			$result[$entry->id] = $entry->$textFieldName;
		}
		return $result;		
	} 
}