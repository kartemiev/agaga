<?php
namespace Vpbxui\ExtensionGroup\Form;

use Zend\Form\Form;
use Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTableInterface;

class ExtensionGroupProfilePickerForm extends Form
{
    protected $extensionGroupProfileTable;
    public function __construct($name = null,
        ExtensionGroupProfileTableInterface $extensionGroupProfileTable
    )
    {
        $this->extensionGroupProfileTable = $extensionGroupProfileTable;

        // we want to ignore the name passed
        parent::__construct('extensiongroupprofilepicker');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setUseInputFilterDefaults(false);
       
         
        $extensionGroupProfileOptions = $this->getExtensionGroupProfilePickerFormOptions();
         
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'profile',
            'attributes' =>  array(
                'id' => 'profile',
                'options' => $extensionGroupProfileOptions,
            ),
            'options' => array(
                'label' => 'Выберите профиль создаваемой группы абонентов',
                'label_attributes' => array(
                    'class'  => 'bold-label'
                ),
            ),
        ));
         
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'далее',
                'id' => 'submitbutton',
            ),
        ));
    }
    protected function getExtensionGroupProfilePickerFormOptions()
    {
        $extensionGroupProfileTable = $this->extensionGroupProfileTable;
        $extensionGroupProfiles = $extensionGroupProfileTable->fetchAll();
        $extensionGroupProfileOptions = array(0 => '');
        foreach ($extensionGroupProfiles as $extensionGroupProfile)
        {
            $extensionGroupProfileOptions[$extensionGroupProfile->id] = $extensionGroupProfile->profilename;
        }
        return $extensionGroupProfileOptions;
    }
   
}