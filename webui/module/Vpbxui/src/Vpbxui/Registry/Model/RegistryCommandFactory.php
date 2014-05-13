<?php
namespace Vpbxui\Registry\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Registry\Model\RegistryCommand;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class RegistryCommandFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
            return new RegistryCommand($serviceLocator->get('Vpbxui\Status\Model\AmiGateway'));
	}
  
}
 