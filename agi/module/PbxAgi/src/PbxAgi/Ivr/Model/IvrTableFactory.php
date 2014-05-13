<?php
namespace PbxAgi\Ivr\Model;

use PbxAgi\Ivr\Model\IvrTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IvrTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('PbxAgi\Ivr\Model\IvrTableGateway');
		return new IvrTable($tableGateway);
	}
}