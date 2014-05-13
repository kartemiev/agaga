<?php
namespace PbxAgi\NumberMatch\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\NumberMatch\Model\NumberMatchTable;

class NumberMatchTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
            return new NumberMatchTable(
            		$serviceLocator->get('PbxAgi\NumberMatch\Model\NumberMatchTableGateway')
					);
    }
}