<?php
namespace PbxAgi\FaxSpoolLog\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class FaxSpoolLogTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
         return  new FaxSpoolLogTable(
         		$serviceLocator->get('PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTableGateway')
		);
    }
}
