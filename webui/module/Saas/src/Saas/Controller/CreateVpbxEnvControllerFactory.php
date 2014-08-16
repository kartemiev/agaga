<?php
namespace Saas\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateVpbxEnvControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;
		return new CreateVpbxEnvController(
				$sl->get('Saas\WizardSessionContainer\WizardSessionContainer'),
				$sl->get('Vpbxui\Extension\Model\ExtensionTable'),
				$sl->get('Saas\VpbxEnv\Model\VpbxEnvTable'),
				$sl->get('Vpbxui\MediaRepos\Model\MediaReposTable'),
				$sl->get('Vpbxui\GeneralSettings\Model\GeneralSettingsTable'),	
				$sl->get('Vpbxui\Service\VpbxidProvider\VpbxidProvider'),
				$sl->get('Vpbxui\Trunk\Model\TrunkTable'),
				$sl->get('Vpbxui\TrunkAssoc\Model\TrunkAssocTable'),
				$sl->get('Vpbxui\Context\Model\ContextTable'),
				$sl->get('Vpbxui\Ivr\Model\IvrTable'),
				$sl->get('Vpbxui\Context\Model\Context'),
				$sl->get('Vpbxui\ExtensionGroup\Model\ExtensionGroupTable'),
				$sl->get('Vpbxui\Extension\Model\Extension'),
				$sl->get('Zend\Db\Adapter\Adapter'),
				$sl->get('Vpbxui\Route\Model\RouteTable'),
				$sl->get('Vpbxui\RegEntry\Model\RegEntryTable'),
				$sl->get('Vpbxui\NumberMatch\Model\NumberMatchTable'),
				$sl->get('Vpbxui\TrunkDestination\Model\TrunkDestinationTable'),
				$sl->get('Vpbxui\CallCentreSchedule\Model\CallCentreScheduleTable')
		);
	}
}