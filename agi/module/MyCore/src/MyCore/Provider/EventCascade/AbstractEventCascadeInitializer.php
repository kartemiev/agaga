<?php
namespace Mycore\Provider\EventCascade;

use Mycore\Provider\EventCascade\EventCascadeAwareInterface; // neccessary for autoloading
use Mycore\Provider\AbstractGenericInitializer;

// Flow and Cascade Event Handling
abstract class AbstractEventCascadeInitializer extends AbstractGenericInitializer
{

    abstract public function getCurrentNamespaceforTraits();

    abstract public function getCurrentClassforTraits();

    public function runCustomSubinitializers()
    {
        $dependency = $this->getDependency();
        if (is_subclass_of($dependency, 'Mycore\\Provider\\EventCascade\\EventCascadeAwareInterface')) {
            $instance = $this->getInitializerInjectorInstance();
            $serviceLocator = $this->getServiceLocator();
            $sl = (method_exists($serviceLocator, 'getServiceLocator')) ? $serviceLocator->getServiceLocator() : $serviceLocator;
            $instanceFQDN = $this->getInstanceFQDN();
            $eventCallback = array(
                $dependency,
                'cbParentEventStart'
            );
            $this->EventCascadeSetPriority();
            $priority = $this->getEventCascadePriority();
            $em = $sl->get('EventManager');
            $shared = $em->getSharedManager();
            // var_dump(get_class($instance));
            $shared->attach('*', get_class($instance) . 'Interface', $eventCallback, $priority);
        }
    }

    protected $eventCascadePriority;

    protected function setEventCascadePriority($eventCascadePriority)
    {
        $this->eventCascadePriority = $eventCascadePriority;
        return $this;
    }

    protected function getEventCascadePriority()
    {
        return $this->eventCascadePriority;
    }

    protected function EventCascadeSetPriority()
    {
        $serviceManager = $this->getServiceLocator();
        $sm = (method_exists($serviceManager, 'getServiceLocator')) ? $serviceManager->getServiceLocator() : $serviceManager;
        
        $config = $sm->get('Config');
        $dependency = $this->getDependency();
        $dependencyClassName = get_class($dependency);
        $instanceFQDN = $this->getInstanceFQDN();
        $priority = &$config['app_vpbx_settings']['cascade_event_manager']['settings']['priorities']["{$dependencyClassName}Interface"]["{$instanceFQDN}Interface"];
        $this->setEventCascadePriority($priority);
    }
}
