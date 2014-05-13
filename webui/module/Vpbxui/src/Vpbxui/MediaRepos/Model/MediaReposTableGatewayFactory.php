<?php
namespace Vpbxui\MediaRepos\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\MediaRepos\Model\MediaRepos;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;

class MediaReposTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new MediaRepos());
        $featureSet = new FeatureSet();
        $featureSet->addFeature(new SequenceFeature('id','mediarepos_id_seq'));
        return new TableGateway('mediarepos', $dbAdapter, $featureSet, $resultSetPrototype);
    }
}