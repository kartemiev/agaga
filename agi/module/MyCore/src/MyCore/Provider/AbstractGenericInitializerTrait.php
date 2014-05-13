<?php

// Abolish class factories!!!
namespace Mycore\Provider;

use Zend\ServiceManager\ServiceLocatorInterface;

trait AbstractGenericInitializerTrait
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

    protected function doInitialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        $namespace = $this->getCurrentNamespaceforTraits();
        $classFullName = $this->getCurrentClassforTraits();
        
        $classname = explode('\\', $classFullName);
        $class = end($classname);
        preg_match('/([\w]*)Initializer$/i', $class, $matches);
        $basename = $matches[1];
        $instanceFQDN = "{$namespace}\\{$basename}";
        if (is_subclass_of($instance, "{$instanceFQDN}AwareInterface")) {
            if ($this->chkBlacklist($instance) && $this->chkWhitelist($instance)) {
                $sl = (method_exists($serviceLocator, 'getServiceLocator')) ? $serviceLocator->getServiceLocator() : $serviceLocator;
                $dependency = $sl->get("{$instanceFQDN}Interface");
                $instance->{'set' . $basename}($dependency);
                $this->setFound();
                $this->setDependency($dependency);
                $this->setInstanceFQDN($instanceFQDN);
            }
        }
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
