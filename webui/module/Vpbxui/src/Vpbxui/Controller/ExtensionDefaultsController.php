<?php

namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\ExtensionDefaults\Form\ExtensionDefaultsForm;

 
class ExtensionDefaultsController extends AbstractActionController {
    
	protected $extensionDefaultsTable;

	const VPBX_NUMBER  = 1;
	
 public function editAction()
    {
        $extensionDefaults = $this->getExtensionDefaultsTable()->getExtensionDefaults(self::VPBX_NUMBER);

        $form  = new ExtensionDefaultsForm();
        $form->bind($extensionDefaults);
        $form->get('submit')->setAttribute('value', 'Сохранить');

        $element = $form->get('diversion_noanswer_duration');
        $element->setAttribute('data-slider-value', $element->getValue());
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($extensionDefaults->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
            	$formdata = $form->getData();
                 $this->getExtensionDefaultsTable()->saveExtensionDefaults($formdata);
                $this->flashMessenger()->addMessage('Настройки успешно сохранены');                  
                return $this->redirect()->toRoute('vpbxui/settings/extensiondefaults');
            }
        }
        $this
        ->getServiceLocator()
        ->get('viewhelpermanager')
        ->get('HeadScript')
        ->appendFile('/js/bootstrap-slider.js')
        ;
        $headLink = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
        $headLink->appendStylesheet('/css/slider.css');
        return array(
            'id' => $id,
            'form' => $form,
        	'flashMessages' => $this->flashMessenger()->getMessages()        		
        );
    }
    protected function getExtensionDefaultsTable()
    {
        if (!$this->extensionDefaultsTable)
        {
            $this->extensionDefaultsTable = $this->getServiceLocator()->get('Vpbxui\ExtensionDefaults\Model\ExtensionDefaultsTable');
        }
        return $this->extensionDefaultsTable;
    }
    
}
