<?php
namespace PbxAgi\FaxSpool\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\FaxSpool\Model\FaxSpoolTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class FaxSpoolTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $faxspooltablegateway = $serviceLocator->get('PbxAgi\FaxSpool\Model\FaxSpoolTableGateway');
        return  new FaxSpoolTable($faxspooltablegateway);
    }
}
