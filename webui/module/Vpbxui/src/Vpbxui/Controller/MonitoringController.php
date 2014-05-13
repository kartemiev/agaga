<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Vpbxui\PbxSettings\Model\PbxSettings;
use PAMI\Client\Exception\ClientException;
use Vpbxui\Status\Model\StatusCommand;
use Vpbxui\Restart\Model\RestartCommand;
use Vpbxui\CallCentreStatus\Model\CallCentreStatusTableInterface;
use Vpbxui\PbxSettings\Model\PbxSettingsTableInterface;
use Vpbxui\Extension\Model\ExtensionTableInterface;

class MonitoringController  extends AbstractActionController {    
    protected $statusTable;
    protected $restartCommand;
    protected $callCentreStatusTable;
    protected $pbxSettingsTable;
    protected $extensionTable;
    public function __construct(
    		StatusCommand $statusCommand, 
    		RestartCommand $restartCommand,
			CallCentreStatusTableInterface $callCentreStatusTable,
    		PbxSettingsTableInterface $pbxSettingsTable,
    		ExtensionTableInterface $extensionTable
			)
    {
    	$this->statusTable = $statusCommand;
    	$this->restartCommand = $restartCommand;
    	$this->callCentreStatusTable = $callCentreStatusTable;
    	$this->pbxSettingsTable = $pbxSettingsTable;
    	$this->extensionTable = $extensionTable;
    }
    public function indexAction()
    {
        $statusCommand = $this->statusTable;
          $statuses =  $statusCommand->fetchAll();  
          if ($statusCommand->isError())
          {
               
               $this->flashMessenger()->addErrorMessage('ошибка подключения к Астериск');
          }
         $extensions = $this->extensionTable->fetchAll();
            
         foreach ($statuses as $key=>$status)
         {
             foreach ($extensions as $extension)
             {
                  if ($status['objectname']==$extension->name)
                 {
                     $statuses[$key]['fromdb'] = $extension;
                 }
             }
         }
          $viewHelperManager =  $this->getServiceLocator()
    								 ->get('viewhelpermanager');
              $viewHelperManager->get('HeadScript')
                 				->appendFile('/js/jquery.jplayer.min')
                    			->appendFile('/js/monitor.js');
              $callCentreStatusTable = $this->callCentreStatusTable;
              
              $callcentrestatus = $callCentreStatusTable
                                    ->fetchAll()
                                    ->current();
              $viewModel = new ViewModel(array(
            'callcentrestatus' => $callcentrestatus,           
            'statuses' => $statuses,        
            'flashMessages' => $this->flashMessenger()->getCurrentErrorMessages()                  
        ));
            $request = $this->getRequest();
            $viewModel->setTerminal($request->isXmlHttpRequest());                  
            return $viewModel;
    }
    public function restartAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Нет');
        
            if ($del == 'Да') {
                $this->restartCommand->invokeHardRestartCommand();
            }        
            return $this->redirect()->toRoute('vpbxui/callcentre/monitoring');
        }
        
        return array(            
        );
    }
    
    public function triggercallcentreAction()
    {
        $pbxSettingsTable = $this->pbxSettingsTable;
        $ccIncomingStatus= $pbxSettingsTable->fetchAll()
                                    ->current()
                                    ->callcentre_status_override;
         
         $ccIncomingStatus = array('enable'=>'FORCE_ENABLED',
                                    'disable'=>'FORCE_DISABLED',
                                    'default'=>'default');         
        $pbxSettings = new PbxSettings();
        $pbxSettings->callcentre_status_override = $ccIncomingStatus[$newState];
        $pbxSettingsTable->savePbxSettings($pbxSettings);
        return $this->redirect()->toRoute('vpbxui/callcentre/monitoring');
    }     
}
 