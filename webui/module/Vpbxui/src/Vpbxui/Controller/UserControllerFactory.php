<?php
namespace Vpbxui\src\Vpbxui\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vpbxui\Controller\UserController;

class UserControllerFactory implements FactoryInterface
{
 public function createService(ServiceLocatorInterface $serviceLocator)
 {
     $sl = (method_exists($serviceLocator, 'getServiceLocator'))?
     $serviceLocator->getServiceLocator : $serviceLocator;
     return new UserController(
         $sl->get('Vpbxui\Role\Model\RoleTable'),
         $sl->get('Vpbxui\Roles\Model\RolesTable')
         );
 }
}
