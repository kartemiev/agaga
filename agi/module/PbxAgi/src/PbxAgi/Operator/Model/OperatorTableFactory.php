<?php
namespace PbxAgi\Operator\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\Operator\Model\OperatorTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class OperatorTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new OperatorTable($serviceLocator->get('OperatorTableGateway'));
    }
}
