<?php
namespace Vpbxui\Extension\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Vpbxui\CallDestination\Model\CallDestination;

class CallGroupFieldset extends Fieldset 
{
    public function __construct()
    {
        parent::__construct('numbers');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new CallDestination());

         
        $this->add(array(
            'name' => 'number',
            'options' => array(
             		
             ),
            'attributes' => array(
            )
        ));
        
        $this->add(array(
        		'name' => 'duration',
        		'attributes' => array(        			
         				'class' => "slider subfieldsetshuffle-data",
        				'data-value'=> 'SEQUENTIAL',        				
        				'data-slider-min'=>"0",
        				'data-slider-max'=>"60",
        				'data-slider-step'=>"1",
        				'data-slider-orientation'=>"horizontal",
        				'data-slider-selection'=>"before",
        				'data-slider-handle'=>'triangle',
        				'value'=>'5',    
	                   'required' => 'required',        				
         		),
        		
         ));
        
        $this->add(array(
        		'name' => 'peerid',
        		'attributes' => array(
        				'type'  => 'hidden',
        		),
        ));
        $this->add(array(
        		'name' => 'numbersetmarkup',
        		'attributes' => array(
        				'class' => 'numbersetmarkup',
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

    /**
     * @return array
     \*/
    public function getInputFilterSpecification()
    {
        return array(
            'number' => array(
                'required' => false,
            ),
        	'duration' => array(
        		'required' => false,
        	),
        		'peerid' => array(
        				'required' => false,
        		)
        );
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