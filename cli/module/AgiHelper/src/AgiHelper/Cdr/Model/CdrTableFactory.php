<?php
namespace AgiHelper\Cdr\Model;

use Zend\ServiceManager\FactoryInterface;
use AgiHelper\Cdr\Model\CdrTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class CdrTableFactory implements FactoryInterface {
	public function createService(ServiceLocatorInterface $serviceLocator) {
	    $tableGateway = $serviceLocator->get('AgiHelper\Cdr\Model\CdrTableGateway');
        $table = new CdrTable($tableGateway);
        return $table;
	}  
}
 