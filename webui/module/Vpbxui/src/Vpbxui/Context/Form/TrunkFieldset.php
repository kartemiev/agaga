<?php
namespace Vpbxui\Context\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
 use Vpbxui\Trunk\Model\TrunkTableInterface;
use Vpbxui\TrunkAssoc\Model\TrunkAssoc;

class TrunkFieldset extends Fieldset 
{
	protected $trunkTable;
    public function __construct($name = null, TrunkTableInterface $trunkTable)
    {
    	$this->trunkTable = $trunkTable;
        parent::__construct('trunks');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new TrunkAssoc());

        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'trunkref',
        		'class'=> 'trunkref',
        		'attributes' =>  array(
        				'id' => 'trunkref',
        				'options' => $this->getTrunkOptions(),
        		),
        		'options' => array(
         				'label_attributes' => array(
        						'class'  => 'bold-label'
        				),
        		),
        ));
     
        
        $this->add(array(
        		'name' => 'trunksetmarkup',
        		'attributes' => array(
        				'class' => 'trunksetmarkup',
        				'type'  => 'hidden',
        		),
        ));
      
    }

    /**
     * @return array
     \*/
    public function getInputFilterSpecification()
    {
        return array(
            'trunkref' => array(
                'required' => true,
            		'filters'  => array(
            				array('name' => 'Int'),
            		),
            ),
        	 
         
        );
    }
 
    protected function getTrunkOptions()
    {
        $trunks = $this->trunkTable->fetchAll();
        $trunkOptions = array();
        foreach ($trunks as $trunk)
        {
            $trunkOptions[$trunk->id] = $trunk->custname;
        }
        return $trunkOptions;
    }
}