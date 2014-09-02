<?php
namespace SaasBootstrap\Service\VpbxEnv;

use Zend\EventManager\Event;
  
class VpbxEnvHandler
{
    public function postUserRegistration(Event $event)
    {
        $controller = $event->getTarget();
        $event->stopPropagation();
        return $controller->redirect()->toRoute('createvpbx');        
    }         
}