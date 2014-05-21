<?php
namespace AgiHelper\Service\RecordedCall;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AgiHelper\Service\RecordedCall\RecordedCallCommands;

class RecordedCallCommandsFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new RecordedCallCommands(
				$serviceLocator->get('AgiHelper\Service\AppConfig\AppConfigService')
			);
	}	
}