<?php
namespace Vpbxui\Navigation;

use Zend\Navigation\Service\AbstractNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Navigation;
use Zend\Navigation\Page\Mvc as MvcPage;

class PopulatedNavigationFactory extends AbstractNavigationFactory
{
    protected $serviceLocator;
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $pages = $this->getPages($serviceLocator);
        $navigation = new Navigation($pages);                
        
        $this->injectExtensionExtraPages($navigation);
        $this->injectGroupExtraPages($navigation); 
        $this->injectPickupGroupExtraPages($navigation);
        $this->injectProfileExtraPages($navigation);
        $this->injectProfileGroupExtraPages($navigation);
        
        $router     = $this->serviceLocator->get('router');
        $this->injectRouter($navigation, $router);
          return $navigation;
    }
    protected function getName()
    {
        return 'default';
    }
    protected function getExtraPages($table, $labelnamefield, $idnamefield,$idqueryparamname, $idprepend, $params)
    {
        $extranavigation = array();
        $sm = $this->serviceLocator;
        $table = $sm->get($table);
        $entries = $table ->fetchAll();   
        foreach ($entries as $entry)
        {
            if (''==$entry->$labelnamefield) continue;
            $extranavigation[] = array_merge(array(
                
                'label' => "<".(string)$entry->$labelnamefield.">", 
                'id' => 'internal'.$entry->$idnamefield,                
                  'params' => array(
                    $idqueryparamname => (string)$entry->$idnamefield,
                ),
                'pages'=>array(
                  ),
                
            ),$params
               );
            
        }
        return $extranavigation;
        
    } 
    protected function injectRouter($navigation, $router) {
        foreach ($navigation->getPages() as $page) {
            if ($page instanceof MvcPage) {
                $page->setRouter($router);
            }
    
            if ($page->hasPages()) {
                $this->injectRouter($page, $router);
            }
        }
    }  
    protected function injectExtensionExtraPages($navigation)
    {
        $route = 'vpbxui/internal';
        $params = array(
            'route'=> $route,
            'module'     => 'vpbxui',
            'controller' => 'Vpbxui\Controller\Internal',
            'action'     => 'edit',
            'resource'   => 'mvc:internalnumber.vpbxui', // resource
            'privilege' => 'edit',
            'visible'    => true, // not visible
        );
        $extrapages = $this->getExtraPages('Vpbxui\Extension\Model\ExtensionTable','extension','id','id','internal',$params);
        $navigation->findOneByRoute('vpbxui/internal')->addPages($extrapages);        
    }
    
    protected function injectGroupExtraPages($navigation)
    {
        $route = 'vpbxui/settings/groups/internal';
        $params = array(
                            'route' => $route,
                            'privilege' => 'internal',
                            'module' => 'vpbxui',
                            'controller' => 'Vpbxui\Controller\ExtensionGroup',
                            'action' => 'edit',
                            'resource' => 'mvc:settingsgroups.vpbxui', // resource       
        );        
        $extrapages = $this->getExtraPages('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable','name','id','id','extensiongroup',$params);
        $navigation->findOneByRoute($route)->addPages($extrapages);        
    }
    protected function injectPickupGroupExtraPages($navigation)
    {
        $route = 'vpbxui/settings/groups/pickup';
        $params = array(
            'route' => $route,
            'privilege' => 'edit',
            'module' => 'vpbxui',
            'controller' => 'Vpbxui\Controller\PickupGroup',
            'action' => 'edit',
            'resource' => 'mvc:settingsgroups.vpbxui', // resource
        );
        $extrapages = $this->getExtraPages('Vpbxui\PickupGroup\Model\PickupGroupTable','custname','custname','custname','pickupgroup',$params);
        $navigation->findOneByRoute($route)->addPages($extrapages);                
    }
    
    protected function injectProfileExtraPages($navigation)
    {
        $route = 'vpbxui/settings/profile/internal';
        $params = array(
            'route' => $route,
            'privilege' => 'edit',
            'module' => 'vpbxui',
            'controller' => 'Vpbxui\Controller\InternalProfile',
            'action' => 'edit',
            'resource' => 'mvc:settingsinternalprofile.vpbxui', // resource
        );
        $extrapages = $this->getExtraPages('Vpbxui\ExtensionProfile\Model\ExtensionProfileTable','profilename','id','id','extensionprofile',$params);
        $navigation->findOneByRoute($route)->addPages($extrapages);    
    }
    
    protected function injectProfileGroupExtraPages($navigation)
    {
        $route = 'vpbxui/settings/profile/group';
        $params = array(
            'route' => $route,
            'privilege' => 'edit',
            'module' => 'vpbxui',
            'controller' => 'Vpbxui\Controller\InternalGroupProfile',
            'action' => 'edit',
            'resource' => 'mvc:settingsinternalgroupsprofile.vpbxui', // resource
        );
        $extrapages = $this->getExtraPages('Vpbxui\ExtensionGroupProfile\Model\ExtensionGroupProfileTable','profilename','id','id','extensiongroupprofile',$params);
        $navigation->findOneByRoute($route)->addPages($extrapages);
    }
    
    
}