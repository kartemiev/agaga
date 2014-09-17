<?php
namespace Saas\WizardSessionContainer;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container as SessionContainer;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;

class WizardSessionContainerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$config = array('authTimeout'=>3600);
		$sessionConfig = new SessionConfig();

		$sessionConfig->setOptions(array(
				'use_cookies' => true,
				'cookie_httponly' => true,
				'gc_maxlifetime' => $config['authTimeout'],
				'cookie_lifetime' => $config['authTimeout'],
		));
		$manager = new SessionManager($sessionConfig);
		$wizardSessionContainer = new WizardSessionContainer('vpbx_wizard');
		return $wizardSessionContainer;
	}
}