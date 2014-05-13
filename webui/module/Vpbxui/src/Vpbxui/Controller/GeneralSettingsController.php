<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Vpbxui\GeneralSettings\Model\GeneralSettingsTable;
use Vpbxui\GeneralSettings\Model\GeneralSettings;
class GeneralSettingsController extends AbstractActionController
{
    const VIRTUAL_VPBX_ID = 1;
    protected $generalSettingsTable;
    public function __construct(GeneralSettingsTable $generalSettingsTable)
    {
        $this->generalSettingsTable = $generalSettingsTable;        
    }
    public function indexAction()
    {
          
      $sl = $this->getServiceLocator();  
      $form = $sl->get('Vpbxui\GeneralSettings\Form\GeneralSettingsForm');

    $request = $this->getRequest();
    if ($request->isPost()) {
            $generalSettings = new GeneralSettings();
            $form->setInputFilter($generalSettings->getInputFilter());
            $form->setData($request->getPost());         
            
        if ($form->isValid()) {
            $generalSettings->exchangeArray($form->getData());
            $generalSettings->vpbxid = self::VIRTUAL_VPBX_ID;
            $this->generalSettingsTable->saveSettings($generalSettings);            
            $this->flashMessenger()->addMessage('Настройки сохранены');             
            return $this->redirect()->toRoute('vpbxui/settings/general');
        }
    } else 
    {
        $generalSettings = $this->generalSettingsTable->getSettings(self::VIRTUAL_VPBX_ID);
        $form->bind($generalSettings);
    }
    $vmtimeoutElement = $form->get('vmtimeout');
    $vmtimeoutElement->setAttribute('data-slider-value', $vmtimeoutElement->getValue());
    $this
    ->getServiceLocator()
    ->get('viewhelpermanager')
    ->get('HeadScript')
    ->appendFile('/js/bootstrap-slider.js')
    ;
    $headLink = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
    $headLink->appendStylesheet('/css/slider.css');
        return array(
            'flashMessages' => $this->flashMessenger()->getMessages(),            
            'form' => $form,
            'generalsettings'=>$generalSettings
        );
        
    }
}