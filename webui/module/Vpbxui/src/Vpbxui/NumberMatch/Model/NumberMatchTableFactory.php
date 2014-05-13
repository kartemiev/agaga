<?php
namespace Vpbxui\NumberMatch\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\NumberMatch\Model\NumberMatchTable;

class NumberMatchTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
            return new NumberMatchTable(
            		$serviceLocator->get('Vpbxui\NumberMatch\Model\NumberMatchTableGateway')
					);
    }
}