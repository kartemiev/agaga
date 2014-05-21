<?php
namespace AgiHelper\RecordedCallsSize\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTable; 

class RecordedCallsSizeTableFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
	    $tableGateway = $serviceLocator->get('AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTableGateway');
        $table = new RecordedCallsSizeTable($tableGateway);
        return $table;
	}
  
}
 