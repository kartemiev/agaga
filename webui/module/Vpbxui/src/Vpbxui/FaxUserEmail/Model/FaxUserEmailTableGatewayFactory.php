<?php
namespace Vpbxui\FaxUserEmail\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\FaxUserEmail\Model\FaxUserEmail;

class FaxUserEmailTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new FaxUserEmail());
        return new TableGateway('faxusers_extra_email', $dbAdapter, null, $resultSetPrototype);
    }
}