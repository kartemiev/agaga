<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Vpbxui\ConferenceSettings\Form\ConferenceSettingsForm;
use Vpbxui\ConferenceSettings\Model\ConferenceSettingsTable;

class ConferenceSettingsController extends AbstractActionController
{
    private $conferenceSettingsTable;
    public function __construct(ConferenceSettingsTable $conferenceSettingsTable)
    {
        $this->conferenceSettingsTable = $conferenceSettingsTable;
    }
      public function indexAction()    
    {
        $request = $this->getRequest();
         
        $conferenceSettings = $this->conferenceSettingsTable->getConferenceSettings();
        
        $form = new ConferenceSettingsForm();
        $attr = $form->get('accesscode')->getAttributes();
        $attr['options']=array($conferenceSettings->accesscode=>$conferenceSettings->accesscode);
        $form->get('accesscode')->setAttributes($attr);
        
        $form->bind($conferenceSettings);
        
        if ($request->isPost()) {
            $inputFilter = $conferenceSettings->getInputFilter();
         			$form->setInputFilter($inputFilter);
         			 
         			$form->setData($request->getPost());
         			if ($form->isValid()) {
         		 
         			    $this->conferenceSettingsTable->saveConferenceSettings($form->getData());         			        
         			 
           			    $this->flashMessenger()->addMessage('Настройки телеконференций успешно сохранены');                		 		    
         			    return $this->redirect()->toRoute('vpbxui/settings/conferencesettings');
         			}
        }
        return array(
            'form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()            
        );
    }
 }