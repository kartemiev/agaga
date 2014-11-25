<?php
namespace Vpbxui\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Vpbxui\DefaultDenyPermit\Model\DefaultDenyPermitTable;
use Vpbxui\DefaultDenyPermit\Model\DefaultDenyPermit;
use Vpbxui\DefaultDenyPermit\Form\DefaultDenyPermitForm;
use Vpbxui\Extension\Model\ExtensionTableInterface;
use Vpbxui\Prune\Model\PruneCommand;
 
class DefaultDenyPermitController extends AbstractActionController
{
    private $defaultDenyPermitTable;
    private $extensionTable;
    private $pruneCommand;
    public function __construct(DefaultDenyPermitTable $defaultDenyPermitTable, ExtensionTableInterface $extensionTable, PruneCommand $pruneCommand)
    {
       $this->defaultDenyPermitTable = $defaultDenyPermitTable;
       $this->extensionTable = $extensionTable;
       $this->pruneCommand = $pruneCommand;
    }
     public function indexAction()    
    {
        $request = $this->getRequest();
         
        $defaultDenyPermit = $this->defaultDenyPermitTable->getDefaultDenyPermit();
        $form = new DefaultDenyPermitForm();
        $form->bind($defaultDenyPermit);
        
        if ($request->isPost()) {
            $inputFilter = $defaultDenyPermit->getInputFilter();
         			$form->setInputFilter($inputFilter);
         			$form->setData($request->getPost());
         			if ($form->isValid()) {
          			    
         			    $this->defaultDenyPermitTable->saveDefautDenyPermit($form->getData());         			        
           			    $this->flashMessenger()->addMessage('Установки безопасности SIP подключения сохранены');                		 		    
         			    return $this->redirect()->toRoute('vpbxui/settings/defaultdenypermit',array('action'=>'prune'));
         			}
        }
        else {
            $defaultDenyPermit = $this->defaultDenyPermitTable->getDefaultDenyPermit();
             
//            $form->setData($data);
         }
        
         
        return array(
            'form' => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()            
        );
    }
    public function pruneAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $prune = $request->getPost('prune', 'Нет');
            
            if ($prune == 'Да') {
                $extensions = $this->extensionTable->fetchAll();
                $countPrune = 0;
                $defaultDenyPermit = $this->defaultDenyPermitTable->getDefaultDenyPermit();
                foreach ($extensions as $extension)
                {
                    $countPrune++;
                    $extension->deny = $defaultDenyPermit->deny;
                    $extension->permit = $defaultDenyPermit->permit;
                    $this->extensionTable->saveExtension($extension);
                    $this->pruneCommand->prunePeer($extension->name);
                 }
                 $this->flashMessenger()->addMessage('новые установки безопасности применены для '.$countPrune.' внутренних номеров');            
             }
           
            return $this->redirect()->toRoute('vpbxui/settings/defaultdenypermit');
            
        }
        return array(
            'flashMessages' => $this->flashMessenger()->getMessages()                        
        );
    }
  }