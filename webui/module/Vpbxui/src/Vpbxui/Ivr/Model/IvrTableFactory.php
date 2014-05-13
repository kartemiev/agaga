<?php
namespace Vpbxui\Ivr\Model;

use Vpbxui\Ivr\Model\IvrTable;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IvrTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$tableGateway = $serviceLocator->get('Vpbxui\Ivr\Model\IvrTableGateway');
		return new IvrTable($tableGateway);
	}
}