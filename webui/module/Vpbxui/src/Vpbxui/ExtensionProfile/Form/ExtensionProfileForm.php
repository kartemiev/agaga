<?php
namespace Vpbxui\ExtensionProfile\Form;

use Zend\Form\Form;
use Vpbxui\ExtensionGroup\Model\ExtensionGroupTable;
use Vpbxui\PickupGroup\Model\PickupGroupTable;

class ExtensionProfileForm extends Form{

    protected $extensionGroupTable;
    protected $pickupGroupTable;
    public function __construct($name = null, 
        ExtensionGroupTable $extensionGroupTable, 
        PickupGroupTable $pickupGroupTable
        )
    {
        $this->extensionGroupTable = $extensionGroupTable;
        $this->pickupGroupTable = $pickupGroupTable;
    	// we want to ignore the name passed
    	parent::__construct('extensionprofile');
    	$this->setAttribute('method', 'post');
    	$this->setAttribute('class', 'form-horizontal');    	 
    	$this->setUseInputFilterDefaults(false);
    	$this->add(array(
    			'name' => 'id',
    			'attributes' => array(
    					'type'  => 'hidden',
    			),
    	));
               
     	 
    	
    $this->add(array(
    			'name' => 'profilename',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Наименование профиля',
    			    'label_attributes' => array(
    			        'class'  => 'bold-label'
    			    ),
    			),    	    
         ));   
    	
    	 
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'extensiontype',
           'attributes' =>  array(
               'id' => 'extensiontype',
               'options' => array(
                   'regular' => 'обычный',
                   'operator' => 'оператор',
                   'fax' => 'факс'
               ),
           ),
           'options' => array(
               'label' => 'Тип номера',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $extensionGroupFormOptions = $this->getExtensionGroupFormOptions();
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'extensiongroup',
           'attributes' =>  array(
               'id' => 'extensiongroup',
               'options' => $extensionGroupFormOptions,
           ),
           'options' => array(
               'label' => 'Группа',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $pickupGroupFormOptions = $this->getPickupGroupFormOptions();
       
        
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'namedpickupgroup',
           'attributes' =>  array(
               'id' => 'namedpickupgroup',
               'options' => $pickupGroupFormOptions,
           ),
           'options' => array(
               'label' => 'Группа перехвата (перехват)',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
        
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'namedcallgroup',
           'attributes' =>  array(
               'id' => 'namedcallgroup',
               'options' => $pickupGroupFormOptions,
           ),
           'options' => array(
               'label' => 'Группа вызовов (перехват)',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       
              
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'extensionrecord',
           'attributes' =>  array(
               'id' => 'extensionrecord',
               'options' => array(
                   'disabled' => 'выключена',
                   'active' => 'активирована',
               ),
           ),
           'options' => array(
               'label' => 'Запись переговоров',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'outgoingcallspermission',
           'attributes' =>  array(
               'id' => 'outgoingcallspermission',
               'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешены',
                   'barred' => 'запрещены',
               ),
           ),
           'options' => array(
               'label' => 'Исходящие вызовы',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'transfer',
           'attributes' =>  array(
               'id' => 'transfer',
               'options' => array(
                   'undefined' => '',
                   'allowed' => 'разрешен',
                   'forbidden' => 'запрещен',
               ),
           ),
           'options' => array(
               'label' => 'Услуга слепого и стандартного перевода вызова',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'hold',
           'attributes' =>  array(
               'id' => 'hold',
               'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешено',
                   'forbidden' => 'запрещено',
               ),
           ),
           'options' => array(
               'label' => 'Услуга удержания вызова',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
        
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'statuschange',
           'attributes' =>  array(
               'id' => 'statuschange',
               'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешено',
                   'forbidden' => 'запрещено',
               ),
           ),
           'options' => array(
               'label' => 'Изменение статуса оператора колл-центра',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'incoming',
           'attributes' =>  array(
               'id' => 'incoming',
               'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешен',
                   'forbidden' => 'запрещен',
               ),
           ),
           'options' => array(
               'label' => 'Прием входящих вызовов',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'memberofcallcentreque',
           'attributes' =>  array(
               'id' => 'memberofcallcentreque',
               'options' => array(
                   'undefined' => '',
                   'true' => 'да',
                   'false' => 'нет',
               ),
           ),
           'options' => array(
               'label' => 'Является участником очереди колл-центра на прием звонков',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));
       
        
       $this->add(array(
           'type' => 'Zend\Form\Element\Select',
           'name' => 'forwarding',
           'attributes' =>  array(
               'id' => 'forwarding',
               'options' => array(
                   'undefined' => '',                    
                   'allowed' => 'разрешена',
                   'forbidden' => 'запрещена',
               ),
           ),
           'options' => array(
               'label' => 'Переадресация вызова',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
           ),
       ));                
       $this->add(array(
           'name' => 'profiledesc',
           'attributes' => array(
               'type'  => 'text',
           ),
           'options' => array(
               'label' => 'Комментарий для профиля',
               'label_attributes' => array(
                   'class'  => 'bold-label'
               ),
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
    protected function getExtensionGroupFormOptions()
    {
        $extensionGroupTable = $this->extensionGroupTable;
        $extensionGroups = $extensionGroupTable->fetchAll();
        $extensionGroupOptions = array(0 => '');
        foreach ($extensionGroups as $extensionGroup)
        {
            $extensionGroupOptions[$extensionGroup->id] = $extensionGroup->name;
        }
        return $extensionGroupOptions;
    }
    protected function getPickupGroupFormOptions()
    {
        $pickupGroupTable = $this->pickupGroupTable;
        $pickupGroups = $pickupGroupTable->fetchAll();
        $pickupGroupOptions = array(0 => '');
        foreach ($pickupGroups as $pickupGroup)
        {
            $pickupGroupOptions[$pickupGroup->name] = $pickupGroup->custname;
        }
        return $pickupGroupOptions;
    }    
}
