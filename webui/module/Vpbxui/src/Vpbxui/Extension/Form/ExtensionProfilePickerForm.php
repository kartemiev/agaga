<?php
namespace Vpbxui\Extension\Form;

use Zend\Form\Form;
use Vpbxui\ExtensionProfile\Model\ExtensionProfileTable;

class ExtensionProfilePickerForm extends Form
{
    protected $extensionProfileTable;
    public function __construct($name = null,
        ExtensionProfileTable $extensionProfileTable
    )
    {
        $this->extensionProfileTable = $extensionProfileTable;

        // we want to ignore the name passed
        parent::__construct('extensionprofilepicker');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setUseInputFilterDefaults(false);
       
         
        $extensionProfileOptions = $this->getExtensionProfilePickerFormOptions();
         
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'profile',
            'attributes' =>  array(
                'id' => 'profile',
                'options' => $extensionProfileOptions,
            ),
            'options' => array(
                'label' => 'Выберите профиль создаваемого абонента',
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
    protected function getExtensionProfilePickerFormOptions()
    {
        $extensionProfileTable = $this->extensionProfileTable;
        $extensionProfiles = $extensionProfileTable->fetchAll();
        $extensionProfileOptions = array(0 => '');
        foreach ($extensionProfiles as $extensionProfile)
        {
            $extensionProfileOptions[$extensionProfile->id] = $extensionProfile->profilename;
        }
        return $extensionProfileOptions;
    }
   
}