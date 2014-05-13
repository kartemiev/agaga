<?php
namespace Vpbxui\Reload\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Reload\Model\ReloadCommand;
 
class ReloadCommandFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
            return new ReloadCommand($serviceLocator->get('Vpbxui\Status\Model\AmiGateway'));
	}
}
 