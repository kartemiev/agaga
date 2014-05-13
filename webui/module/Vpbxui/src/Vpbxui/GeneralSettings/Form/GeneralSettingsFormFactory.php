<?php
namespace Vpbxui\GeneralSettings\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\GeneralSettings\Form\GeneralSettingsForm;

class GeneralSettingsFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return  new GeneralSettingsForm(
            $serviceLocator->get('Vpbxui\MediaRepos\Model\MediaReposTable')
            );
    }
}