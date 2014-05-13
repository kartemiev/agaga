<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Controller\CallCentreScheduleController;

class CallCentreScheduleControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator, 'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new CallCentreScheduleController(
				$sl->get('Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTable'),
				$sl->get('Vpbxui\CallCentreSchedule\Model\TimeSpotTable')
		);
	}
}