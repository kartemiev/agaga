<?php
namespace PbxAgi\SkypeAlias\Model;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use PbxAgi\SkypeAlias\Model\SkypeAlias;

class SkypeAliasTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
 		$resultSetPrototype->setArrayObjectPrototype(new SkypeAlias());	 
 		$featureSet = new FeatureSet();
 		$featureSet->addFeature($serviceLocator->get('PbxAgi\Service\VpbxidProvider\VpbxidFeature'));
		return new TableGateway('skype_aliases', $dbAdapter, $featureSet, $resultSetPrototype);
	}
}