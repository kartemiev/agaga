<?php
namespace Saas\Service\AppConfig;

use Saas\Service\AppConfig\AppConfigInterface;
use Zend\Stdlib\AbstractOptions;

class AppConfigService extends AbstractOptions implements AppConfigInterface
{
 
    protected $tempMediaPath;
	/**
     * @return the $tempMediaPath
     */
    public function getTempMediaPath()
    {
        return $this->tempMediaPath;
    }

	/**
     * @param field_type $tempMediaPath
     */
    public function setTempMediaPath($tempMediaPath)
    {
        $this->tempMediaPath = $tempMediaPath;
    }

   
 
}
