<?php
namespace Saas\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UploadMediaControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		
		return new UploadMediaController(
				$sl->get('Saas\WizardSessionContainer\WizardSessionContainer'),
				$sl->get('Saas\TempMedia\Model\TempMediaTable'),
		        $sl->get('Saas\Service\AppConfig\AppConfigService')
			);
	}
}