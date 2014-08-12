<?php
namespace Saas\TempMedia\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class TempMediaTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new TempMedia());
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('id','temp_media_id_seq'));
        return new TableGateway('temp_media', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}