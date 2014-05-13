<?php
namespace Pbxagi\Media\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use PbxAgi\Media\Model\Media;

class MediaTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        return new TableGateway('mediarepos', $dbAdapter, null, new HydratingResultSet(new ReflectionHydrator(), new Media()));
    }
}
