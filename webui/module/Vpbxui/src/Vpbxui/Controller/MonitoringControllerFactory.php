<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Controller\MonitoringController;

class MonitoringControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new MonitoringController(
			$sl->get('Vpbxui\Status\Model\StatusCommand'),
			$sl->get('Vpbxui\Restart\Model\RestartCommand'),
			$sl->get('Vpbxui\CallCentreStatus\Model\CallCentreStatusTable'),
			$sl->get('Vpbxui\PbxSettings\Model\PbxSettingsTable'),
			$sl->get('Vpbxui\Extension\Model\ExtensionTable')		
		);
	}
}