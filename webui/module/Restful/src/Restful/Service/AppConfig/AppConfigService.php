<?php
namespace Restful\Service\AppConfig;

use Zend\Stdlib\AbstractOptions;

class AppConfigService extends AbstractOptions implements AppConfigInterface
{
    protected $limitPlan;
	/**
     * @return the $limitPlan
     */
    public function getLimitPlan()
    {
        return $this->limitPlan;
    }

	/**
     * @param field_type $limitPlan
     */
    public function setLimitPlan($limitPlan)
    {
        $this->limitPlan = $limitPlan;
        return $this;
    }

}
