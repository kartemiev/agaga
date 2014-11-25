<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class DefaultDenyPermitControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
       $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;       
       return new DefaultDenyPermitController(
            $sl->get('Vpbxui\DefaultDenyPermit\Model\DefaultDenyPermitTable'),
           $sl->get('Vpbxui\Extension\Model\ExtensionTable'),
           $sl->get('Vpbxui\Prune\Model\PruneCommand')
           );
    }
}