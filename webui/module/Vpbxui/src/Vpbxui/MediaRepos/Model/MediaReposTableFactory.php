<?php
namespace Vpbxui\MediaRepos\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\MediaRepos\Model\MediaReposTable;

class MediaReposTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Vpbxui\MediaRepos\Model\MediaReposTableGateway');
        $table = new MediaReposTable($tableGateway);
        return $table;
    }    
}