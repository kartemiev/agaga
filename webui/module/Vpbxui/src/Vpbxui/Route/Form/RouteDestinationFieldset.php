<?php
namespace Vpbxui\Route\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ObjectProperty as ObjectPropertyHydrator;
use Vpbxui\TrunkDestination\Model\TrunkDestination;
use Vpbxui\Trunk\Model\TrunkTable; 
use Vpbxui\NumberMatch\Model\NumberMatchTable;

class RouteDestinationFieldset extends Fieldset 
{
    public function __construct(
    			TrunkTable $trunkTable, 
    			NumberMatchTable $numberMatchTable
			)
    {
        parent::__construct('destinations');
        $this->setHydrator(new ObjectPropertyHydrator(false))
             ->setObject(new TrunkDestination());
              
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'trunkref',
        		'attributes' =>  array(
        				'id' => 'trunkref',
         				'options' => $this->getInputListOptions($trunkTable, 'custname'),
        		),
        		'options' => array(
        				'label' => 'транк',
        				'label_attributes' => array(
        						'class'  => 'bold-label'
        				),
        		),
        ));
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'numbermatchref',
        		'attributes' =>  array(
        				'id' => 'numbermatchref',
        				'options' => $this->getInputListOptions($numberMatchTable, 'custname'),
        		),
        		'options' => array(
        				'label' => 'фильтр номера',
        				'label_attributes' => array(
        						'class'  => 'bold-label'
        				),	
        		),
        ));
        $this->add(array(
        		'name' => 'routedestinationfieldsetsetmarkup',
        		'attributes' => array(
        				'class' => 'destinationsetmarkup',
        				'type'  => 'hidden',
        		),
        ));
        /*
        $this->add(array(
        		'name' => 'deletebutton',
        		'attributes' => array(
        				'class' => 'deletebutton',
        				'type'  => 'button',
        				'value'=>'x'        				
        		),
         ));
         */
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
    public function getInputFilterSpecification()
    {
          return array(
          	 
            'trunkref' => array(
                'required' => false,
            		 
            ),
        	 
          		'numbermatchref' => array(
          				'required' => false,
          				 
          		),
        );
    }
}