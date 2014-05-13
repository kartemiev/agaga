<?php
namespace PbxAgi\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Http\Request; 
use Zend\Mvc\Router\RouteInterface;
  

class MockedRedirector extends AbstractPlugin    {
    protected $router;
    

        public function __construct(RouteInterface $router) {
        $this->router = $router;
    }

    public function dispatch($uri, $params = array())
    {
      $this->getController()->getServiceLocator()
              ->get('ClientImpl')->setVariable('DISPATCHED',$uri);
        return true;
    }
}
