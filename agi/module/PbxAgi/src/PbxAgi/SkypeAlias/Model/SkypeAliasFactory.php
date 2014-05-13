<?php
namespace PbxAgi\SkypeAlias\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\SkypeAlias\Model\SkypeAlias;

class SkypeAliasFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
		$adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		return new SkypeAlias($adapter);
   	}
}