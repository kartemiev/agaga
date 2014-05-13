<?php
namespace Vpbxui\Status\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Status\Model\StatusCommand;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class StatusCommandFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
            return new StatusCommand($serviceLocator->get('Vpbxui\Status\Model\AmiGateway'));
	}
  
}
 