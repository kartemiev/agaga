<?php
namespace Mycore\Provider;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\InitializerInterface;

abstract class AbstractGenericInitializer implements InitializerInterface
{

    protected function getBlacklist()
    {
        return array();
    }

    protected function getWhitelist()
    {
        return array();
    }

    protected $found = false;

    protected function setFound()
    {
        $this->found = true;
        return $this;
    }

    protected function isFound()
    {
        return $this->found;
    }

    protected $dependency;

    protected function getDependency()
    {
        return $this->dependency;
    }

    protected function setDependency($dependency)
    {
        $this->dependency = $dependency;
        return $this;
    }

    protected function getGenericInitializerInterfaceName()
    {
        $instanceFQDN = $this->getInstanceFQDN();
        return "{$instanceFQDN}AwareInterface";
    }

    protected function runCustomSubinitializers()
    {}

    public function runGenericClassInitializer()
    {
        $instance = $this->getInitializerInjectorInstance();
        $implementsif = $this->getGenericInitializerInterfaceName();
        if (! is_subclass_of($instance, $implementsif))
            return;
        
        $instanceFQDN = $this->getInstanceFQDN();
        $basename = $this->getBaseName();
        $serviceLocator = $this->getServiceLocator();
        $sl = (method_exists($serviceLocator, 'getServiceLocator')) ? $serviceLocator->getServiceLocator() : $serviceLocator;
        $dependency = $sl->get("{$instanceFQDN}Interface");
        $instance->{'set' . $basename}($dependency);
        $this->setDependency($dependency);
        $this->runCustomSubInitializers();
        $this->setFound();
    }

    protected $baseName;

    protected function setBaseName($baseName)
    {
        $this->baseName = $baseName;
        return $this;
    }

    protected function getBaseName()
    {
        return $this->baseName;
    }

    protected $instanceFQDN;

    protected function setInstanceFQDN($instanceFQDN)
    {
        $this->instanceFQDN = $instanceFQDN;
        return $this;
    }

    protected function getInstanceFQDN()
    {
        return $this->instanceFQDN;
    }

    protected $initializerInjectorInstance;

    protected function setInitializerInjectorInstance($initializerInjectorInstance)
    {
        $this->initializerInjectorInstance = $initializerInjectorInstance;
        return $this;
    }

    protected function getInitializerInjectorInstance()
    {
        return $this->initializerInjectorInstance;
    }

    protected $serviceLocator;

    protected function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    protected function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        $namespace = $this->getCurrentNamespaceforTraits();
        $classFullName = $this->getCurrentClassforTraits();
        
        $classname = explode('\\', $classFullName);
        $class = end($classname);
        preg_match('/([\w]*)Initializer$/i', $class, $matches);
        $basename = $matches[1];
        $instanceFQDN = "{$namespace}\\{$basename}";
        $this->setBaseName($basename);
        $this->setInstanceFQDN($instanceFQDN);
        $this->setInitializerInjectorInstance($instance);
        $this->setServiceLocator($serviceLocator);
        do {
            if (! ($this->chkBlacklist($instance) || $this->chkWhitelist($instance)))
                break;
            $this->runGenericClassInitializer();
        } while (0);
        return $this;
    }

    protected function chkBlacklist($instance)
    {
        $blacklist = $this->getBlacklist();
        foreach ($blacklist as $blacklisted) {
            if (is_subclass_of($instance, $blacklisted))
                return false;
        }
        return true;
    }

    protected function chkWhitelist($instance)
    {
        $whitelist = $this->getWhitelist();
        
        if (count($whitelist) > 0) {
            foreach ($whitelist as $wlentry) {
                if (is_subclass_of($instance, $wlentry)) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }
}
