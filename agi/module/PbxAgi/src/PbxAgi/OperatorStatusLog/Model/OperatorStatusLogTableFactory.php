<?php
namespace PbxAgi\OperatorStatusLog\Model;

use Zend\ServiceManager\FactoryInterface;
use PbxAgi\OperatorStatusLog\Model\OperatorStatusLogTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class OperatorStatusLogTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new OperatorStatusLogTable($serviceLocator->get('OperatorStatusLogTableGateway'));
    }
}
