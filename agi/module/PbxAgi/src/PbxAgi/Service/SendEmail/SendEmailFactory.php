<?php
namespace PbxAgi\Service\SendEmail;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Trunk\Model\TrunkTable;
use PbxAgi\Service\SendEmail\SendEmail;

class SendEmailFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$sendEmailTransport = $serviceLocator->get('SendmailTransport');
		return new SendEmail($sendEmailTransport);
	}
}