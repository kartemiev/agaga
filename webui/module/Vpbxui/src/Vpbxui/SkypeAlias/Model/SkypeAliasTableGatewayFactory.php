<?php
namespace Vpbxui\SkypeAlias\Model;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\SequenceFeature;
 
class SkypeAliasTableGatewayFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new ResultSet();
		$skypeAlias = $serviceLocator->get('Vpbxui\SkypeAlias\Model\SkypeAlias');
 		$resultSetPrototype->setArrayObjectPrototype($skypeAlias);	 
 		$featureSet = new FeatureSet($serviceLocator->get('Vpbxui\Service\VpbxidProvider\VpbxidFeature'));
		return new TableGateway('skype_aliases', $dbAdapter, $featureSet, $resultSetPrototype);
	}
}