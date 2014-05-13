<?php
namespace Mycore\Provider\EventCascade;

use Zend\EventManager\EventInterface;
use Mycore\Provider\AbstractAwareInterface;

interface EventCascadeAwareInterface extends AbstractAwareInterface
{

    function cbParentEventStart(EventInterface $e);

    function cbParentEventRun();

    function cbParentEventPassOntoHandlingChainDescendants();
}
