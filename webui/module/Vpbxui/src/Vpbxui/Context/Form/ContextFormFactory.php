<?php
namespace Vpbxui\Context\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Context\Form\ContextForm;

class ContextFormFactory implements FactoryInterface
{
	protected $extensionTable;
	protected $ivrTable;
	protected $trunkFieldset;
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		return new ContextForm(null, 
				$serviceLocator->get('Vpbxui\Extension\Model\ExtensionTable'),
				$serviceLocator->get('Vpbxui\Ivr\Model\IvrTable'),
				$serviceLocator->get('Vpbxui\Context\Form\TrunkFieldset'),
				$serviceLocator->get('Vpbxui\Feature\Model\FeatureTable')
			);		 
 	}
}