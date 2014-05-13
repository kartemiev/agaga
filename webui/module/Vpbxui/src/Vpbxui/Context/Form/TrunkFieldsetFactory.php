<?php
namespace Vpbxui\Context\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Context\Form\TrunkFieldset;

class TrunkFieldsetFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new TrunkFieldset(null, $serviceLocator->get('Vpbxui\Trunk\Model\TrunkTable'));
 	}    
}