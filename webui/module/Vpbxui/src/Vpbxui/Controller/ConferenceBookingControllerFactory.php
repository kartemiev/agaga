<?php
namespace Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Controller\ConferenceBookingController;

class ConferenceBookingControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$sl = (method_exists($serviceLocator,'getServiceLocator'))?$serviceLocator->getServiceLocator():$serviceLocator;       
        $conferenceForm  = $sl->get('Vpbxui\Conference\Form\ConferenceForm');
        $conferenceTable = $sl->get('Vpbxui\Conference\Model\ConferenceTable');
        $dateTime = $sl->get('Vpbxui\DateTime');
        $conference = $sl->get('Vpbxui\Conference\Model\Conference');
        $conferenceFreeTable = $sl->get('Vpbxui\ConferenceFree\Model\ConferenceFreeTable');
        return new ConferenceBookingController($conferenceForm, $conferenceTable, $dateTime, $conference, $conferenceFreeTable);
    }    
}