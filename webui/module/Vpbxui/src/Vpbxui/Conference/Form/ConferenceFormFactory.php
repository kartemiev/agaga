<?php
namespace Vpbxui\Conference\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class ConferenceFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $conferenceFreeTable = $serviceLocator->get('Vpbxui\ConferenceFree\Model\ConferenceFreeTable');
        return new ConferenceForm($conferenceFreeTable);
    }
}