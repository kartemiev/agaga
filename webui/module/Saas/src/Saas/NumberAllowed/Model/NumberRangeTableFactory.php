<?php
namespace Saas\NumberAllowed\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\NumberMatch\Model\NumberMatchTable;

class NumberRangeTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
            return new NumberRangeTable(
            		  $serviceLocator->get('Saas\NumberAllowed\Model\NumberRangeTableGateway')
					);
    }
}