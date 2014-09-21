<?php
namespace Saas\WizardSessionContainer;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
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
		$wizardSessionContainer->setTempMediaTable($serviceLocator->get('Saas\TempMedia\Model\TempMediaTable'));
		$tempMediaTable = $serviceLocator->get('Saas\TempMedia\Model\TempMediaTable');

 
		if (!isset($wizardSessionContainer->media))
		{
		    $greeting = $tempMediaTable->fetchAll(array('isdefault'=>true,'mediatype'=>'greeting'))->current();
		    $greetingofftime = $tempMediaTable->fetchAll(array('isdefault'=>true,'mediatype'=>'greetingofftime'))->current();
		    $mohtone = $tempMediaTable->fetchAll(array('isdefault'=>true,'mediatype'=>'mohtone'))->current();
		    $ringingtone = $tempMediaTable->fetchAll(array('isdefault'=>true,'mediatype'=>'ringingtone'))->current();
		    
		  $wizardSessionContainer->media = array(
		        'wtgreeting'=>$greeting,
		        'wegreeting'=>$greetingofftime,
		         'musiconhold'=>$mohtone,
		         'ringingbacktone'=>$ringingtone);
		 
		}
		return $wizardSessionContainer;
	}
}