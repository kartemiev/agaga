<?php
namespace Vpbxui\FaxUser\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\FaxUser\Model\FaxUser;

class FaxUserTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
         $resultSetPrototype->setArrayObjectPrototype(new FaxUser());
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('id','faxusers_id_seq'));        
        return new TableGateway('faxusers', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}