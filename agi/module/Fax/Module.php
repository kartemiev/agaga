<?php
namespace Fax;

class Module
{
    public function getControllerConfig()
    {
        return array(
            'invokables'=>array(
                'Fax\Controller\ParseFaxEmail' => 'Fax\Controller\ParseFaxEmailController',           
            ),
      
        );
    
    }
    public function getConfig()
    {
         return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
}