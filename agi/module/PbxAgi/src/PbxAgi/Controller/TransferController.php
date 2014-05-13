<?php
namespace PbxAgi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;

class TransferController extends AbstractActionController
{
	protected $varManager;
	public function __construct(ChannelVarManagerInterface $varManager)
	{
	    $this->varManager = $varManager;
	}
	public function indexAction()
	{
	    $this->varManager->setCallIsTransfered();
	    $this->forward()->dispatch('Dialout');
	}    
}