<?php
namespace Vpbxui\NumberMatch\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ObjectProperty as ObjectPropertyHydrator;
use Vpbxui\RegEntry\Model\RegEntry;

class RegEntryFieldset extends Fieldset 
{
    public function __construct($name = null)
    {
        parent::__construct('regentries');
      
        $this->setHydrator(new ObjectPropertyHydrator(false))
             ->setObject(new RegEntry());
        
        $this->add(array(
        		'name' => 'regexpression',
        		'attributes' => array(
         				'type'  => 'input',
        		),
        		'options' => array(
         				'label_attributes' => array(
        						'class'  => 'bold-label'
        				),
        		),
        ));
        $this->add(array(
        		'name' => 'regentrysetmarkup',
        		'attributes' => array(
        				'class' => 'regentrysetmarkup',
        				'type'  => 'hidden',
        		),
        ));
      
    }

    public function getInputFilterSpecification()
    {
        return array(
            'regexpression' => array(
                'required' => true,       
            ),
        		'regentrysetmarkup' => array(
        				'required' => true,
        			 
        		),
         
        );
    }
}