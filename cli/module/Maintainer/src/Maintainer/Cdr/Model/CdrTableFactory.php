<?php
namespace Maintainer\Cdr\Model;

use Zend\ServiceManager\FactoryInterface;
use Maintainer\Cdr\Model\CdrTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class CdrTableFactory implements FactoryInterface {
	public function createService(ServiceLocatorInterface $serviceLocator) {
	    $tableGateway = $serviceLocator->get('Maintainer\Cdr\Model\CdrTableGateway');
        $table = new CdrTable($tableGateway);
        return $table;
	}  
}
 