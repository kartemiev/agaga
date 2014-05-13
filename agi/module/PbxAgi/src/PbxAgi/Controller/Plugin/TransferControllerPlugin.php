<?php
namespace PbxAgi\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;

class TransferControllerPlugin extends AbstractPlugin
{
    protected $channelVarManager;
    public function __construct(ChannelVarManagerInterface $channelVarManager)
    {
        $this->channelVarManager = $channelVarManager;
    }
    public function __invoke()
    {
        $this->channelVarManager
            ->setTransferContext();
    }      
}
