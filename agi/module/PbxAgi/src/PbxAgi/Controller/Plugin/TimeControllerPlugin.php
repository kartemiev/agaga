<?php
namespace PbxAgi\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use PbxAgi\Controller\Plugin\TimeControllerPluginInterface;
use PbxAgi\CallCentreStatus\Model\CallCentreStatusTableInterface;

class TimeControllerPlugin extends AbstractPlugin
{
    protected $callCentreStatusTable;
    public function __construct(CallCentreStatusTableInterface $callCentreStatusTable)
    {
    	$this->callCentreStatusTable = $callCentreStatusTable;
    }
    public function isWorkingHours()
    {
        $callCentreStatusTable = $this->callCentreStatusTable;
        $status = $callCentreStatusTable->fetchAll()
                        ->current();
        return $status->status;
    }
    
}