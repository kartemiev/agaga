<?php
namespace Vpbxui\Cdr\Model;

use Zend\ServiceManager\FactoryInterface;
use Vpbxui\Cdr\Model\CdrTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class CdrTableFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
	    $tableGateway = $serviceLocator->get('Vpbxui\Cdr\Model\CdrTableGateway');
        $table = new CdrTable($tableGateway);
        return $table;
	}
  
}
 