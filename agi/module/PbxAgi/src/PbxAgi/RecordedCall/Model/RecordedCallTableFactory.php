<?php
namespace PbxAgi\RecordedCall\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Cdr\Model\RecordedCallTable;

class RecordedCallTableFactory implements FactoryInterface {

	public function createService(ServiceLocatorInterface $serviceLocator) {
	    $tableGateway = $serviceLocator->get('PbxAgi\Cdr\Model\RecordedCallTableGateway');
        $table = new RecordedCallTable($tableGateway);
        return $table;
	}
  
}
 