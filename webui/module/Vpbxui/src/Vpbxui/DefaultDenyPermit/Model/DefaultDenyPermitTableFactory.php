<?php
namespace Vpbxui\DefaultDenyPermit\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DefaultDenyPermitTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\DefaultDenyPermit\Model\DefaultDenyPermitTableGateway');
         
        return new DefaultDenyPermitTable(
        		$tableGateway
 			);
    }
}