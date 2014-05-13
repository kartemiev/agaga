<?php
namespace Mycore\Provider\EventCascade;

use Zend\EventManager\EventInterface;

trait EventCascadeAwareTrait
{

    protected $cbParentEventPreventPropagate = false;

    protected $cbParentEventPassOntoHandlingChainDescendants;

    protected $cbParentEvent;

    protected $cbParentEventInvokeParameters = null;

    protected function setCbParentEventInvokeParameters($cbParentEventInvokeParameters)
    {
        $this->cbParentEventInvokeParameters = $cbParentEventInvokeParameters;
        return $this;
    }

    protected function getCbParentEventInvokeParameters()
    {
        return $this->cbParentEventInvokeParameters;
    }

    protected function setCbParentEvent(EventInterface $e)
    {
        $this->cbParentEvent = $e;
        return $this;
    }

    protected function getCbParentEvent()
    {
        return $this->cbParentEvent;
    }

    protected function cbParentEventPreventPropagate()
    {
        $event = $this->getCbParentEvent();
        $event->stopPropagation();
        return $this;
    }

    protected function cbParentEventPassOntoHandlingChainDescendants()
    {
        $this->cbParentEventTriggerSelf();
    }

    public function cbParentEventStart(EventInterface $e)
    {
        //
        // do whatever with the event - can prevent it from propagating though
        // the following logic ought to be incorporated into concrete class receiving the event:
        //
        // check whether event is matched - if event matched:
        // 1. prevent propagating
        // 2. process it if ought to or trigger self to let descendants' services to take care of it
        //
        // if event is not matched:
        // 1. do nothing
        //
        $this->setCbParentEvent($e);
        $this->cbParentEventRun();
        return $this;
    }

    protected $cbParentEventIsMatchedValue;

    public function cbParentEventIsMatched()
    {
        return $this->cbParentEventIsMatchedValue;
    }

    public function setCbParentEventIsMatched($cbParentEventIsMatchedValue)
    {
        return $this->cbParentEventIsMatchedValue = $cbParentEventIsMatchedValue;
    }

    protected function cbParentEventTriggerSelf()
    {
        $serviceLocator = $this->getServiceLocator();
        $sl = (method_exists($serviceLocator, 'getServiceLocator')) ? $sl->getServiceLocator() : $serviceLocator;
        $em = $sl->get('EventManager');
        $getCurrentclassforTraits = $this->getCurrentClassforTraits();
        $eventClassFQDN = "{$getCurrentclassforTraits}Interface";
        $em->trigger("{$eventClassFQDN}Interface", $this, $this->getCbParentEventInvokeParameters());
        return $this;
    }
}
