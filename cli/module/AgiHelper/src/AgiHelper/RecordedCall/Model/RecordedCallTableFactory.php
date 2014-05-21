<?php
namespace AgiHelper\RecordedCall\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AgiHelper\RecordedCall\Model\RecordedCallTable;

class RecordedCallTableFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
	    $tableGateway = $serviceLocator->get('AgiHelper\RecordedCall\Model\RecordedCallTableGateway');
        $table = new RecordedCallTable($tableGateway);
        return $table;
	}
  
}
 