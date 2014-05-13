<?php
namespace Mycore\Provider;

use Mycore\Provider\AbstractGenericInitializerTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

trait GenericInitializerTrait
{
    
    use AbstractGenericInitializerTrait;

    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        $this->doInitialize($instance, $serviceLocator);
    }
}

