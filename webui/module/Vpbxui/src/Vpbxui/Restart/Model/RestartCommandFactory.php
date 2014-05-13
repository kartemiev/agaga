<?php
namespace Vpbxui\Restart\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Restart\Model\RestartCommand;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class RestartCommandFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
            return new RestartCommand($serviceLocator->get('Vpbxui\Status\Model\AmiGateway'));
	}
  
}
 