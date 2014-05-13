<?php
namespace PbxAgi\Peer\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PbxAgi\Peer\Model\PeerTable;

class PeerTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $peerTableGateway = $serviceLocator->get('PeerTableGateway');
       return new PeerTable($peerTableGateway);
    }
}
