<?php
namespace PbxAgi\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use PbxAgi\Entity\CallEntityInterface;
use PbxAgi\Service\AppConfig\AppConfigInterface;
use PbxAgi\Extension\Model\Extension;
use PbxAgi\Service\PermissionResolver\PermissionResolver;

class FeatureCheckPermissionPlugin extends AbstractPlugin
{
    protected $callEntity;
    protected $extensiongroupTable;
    protected $permissionResolver;
    public function __construct(CallEntityInterface $callEntity, PermissionResolver $permissionResolver)
    {
        $this->callEntity = $callEntity;
        $this->permissionResolver = $permissionResolver;        
    }
    public function __invoke($featureName, $positiveresult, $bearerType = 'CallOwner')
    {
        $callEntity = $this->callEntity;
        $bearerTypeGetter = 'get'.$bearerType;
        $callOwner = $callEntity->$bearerTypeGetter();
        $extension = new Extension();
        $extension->exchangeArray($callOwner->getArrayCopy());    
        $result = $this->permissionResolver->resolv($featureName, $extension);                       
        $value = $result->getValue();
        $value = (isset($value))?$value:null;        
        $permitted = (in_array(strtoupper($value),array_map('strtoupper', $positiveresult)));
        return $permitted;
    }        
}