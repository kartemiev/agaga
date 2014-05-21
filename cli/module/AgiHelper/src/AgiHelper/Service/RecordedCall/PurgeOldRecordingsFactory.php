<?php
namespace AgiHelper\Service\RecordedCall;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AgiHelper\Service\RecordedCall\PurgeOldRecordings;

class PurgeOldRecordingsFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new PurgeOldRecordings(
				$serviceLocator->get('AgiHelper\Service\AppConfig\AppConfigService'),
				$serviceLocator->get('AgiHelper\RecordedCall\Model\RecordedCallTable'),
				$serviceLocator->get('AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTable'),
				$serviceLocator->get('AgiHelper\Cdr\Model\CdrTable')				
		);		
	}
}