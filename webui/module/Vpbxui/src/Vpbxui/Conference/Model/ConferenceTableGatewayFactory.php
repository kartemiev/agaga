<?php
namespace Vpbxui\Conference\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Vpbxui\Conference\Model\Conference;
use Zend\Db\ResultSet\ResultSet; 
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
 
class ConferenceTableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype($serviceLocator->get('Vpbxui\Conference\Model\Conference'));
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('id','conference_serial'));
        return new TableGateway('conference', $dbAdapter, $featureSet, $resultSetPrototype);
                
    }
}
