<?php
namespace Vpbxui\Prune\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Prune\Model\PruneCommand;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class PruneCommandFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
            return new PruneCommand($serviceLocator->get('Vpbxui\Status\Model\AmiGateway'));
	}
  
}
 