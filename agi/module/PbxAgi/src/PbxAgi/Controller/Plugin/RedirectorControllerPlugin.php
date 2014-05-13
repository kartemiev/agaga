<?php
namespace PbxAgi\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Http\Request; 
use Zend\Mvc\Router\RouteInterface;


class RedirectorControllerPlugin extends AbstractPlugin   {
    protected $router;
    public function __construct(RouteInterface $router) {
        $this->router = $router;
    }

    public function dispatch($uri, $params = array())
    {
        $request = new Request;
       $request->setUri($uri); 
       $match = $this->router->match($request);
       $forward = $this->getController()->forward();
       if ($match){
           $controller = $match->getParam('controller');
           $namespace = $match->getParam('__NAMESPACE__');         
           $action = $match->getParam('action');
           return $forward->dispatch(implode('\\',array($namespace,$controller)), 
                   array_merge(array('action' => $action), $params));
        }
    }
}