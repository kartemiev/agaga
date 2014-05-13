<?php
namespace PbxAgi\Service\ShortDialMenu\IndexShortDialMenu;

  
use Zend\ServiceManager\InitializerInterface;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\ShortDial\Model\ShortDialTable;
use Zend\ServiceManager\ServiceLocatorInterface;
class CursorContainerInitializer implements InitializerInterface
{
    protected $call;
    protected $shortDialTable;
    public function __construct(CallEntityInterface $call, ShortDialTable $shortDialTable)
    {
        $this->call = $call;
        $this->shortDialTable = $shortDialTable;
    }
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
         $peerId = $this->call->getCallOwner()->getId();
        $shortDial = $this->shortDialTable->fetchAll(array('peerid'=>$peerId));
        if ($shortDial)
        {
              $shortDialRecord = $shortDial->current();
             if ($shortDialRecord){
                $instance->setId($shortDialRecord->id);
            }
        }
    }
}