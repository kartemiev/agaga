<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InternalControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
        return new InternalController(
                $sl->get('Vpbxui\Extension\Model\ExtensionTable'),
                $sl->get('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable'),
                $sl->get('Vpbxui\ExtensionProfile\Model\ExtensionProfileTable'),
                $sl->get('Vpbxui\OperatorStatusLog\Model\OperatorStatusLogTable'),
                $sl->get('Vpbxui\Extension\Model\Extension'),
                $sl->get('Vpbxui\Extension\Model\ExtensionProfilePicker'),
                $sl->get('Navigation'),
                $sl->get('Vpbxui\Prune\Model\PruneCommand'),
                $sl->get('Vpbxui\Service\PasswordGen\PasswordGen'),
                $sl->get('Vpbxui\FreeExtension\Model\FreeExtensionTable'),
                $sl->get('Vpbxui\Extension\Form\ExtensionForm'),
                $sl->get('Vpbxui\CallDestination\Model\CallDestinationTable'),
                $sl->get('Vpbxui\DefaultDenyPermit\Model\DefaultDenyPermitTable'),
                $sl->get('Vpbxui\Extension\Form\ExtensionProfilePickerForm')
            );
    }    
}
