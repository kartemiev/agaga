<?php
namespace PbxAgi\DialDescriptor\DialOptions;

use PbxAgi\DialDescriptor\AbstractDialOptionParametrized;
use PbxAgi\DialDescriptor\DialOptions\LimitCallWithWarningDialOptionInterface;
 
class LimitCallWithWarningDialOption extends AbstractDialOptionParametrized implements LimitCallWithWarningDialOptionInterface
{
    protected $limitTime;
    protected $warningTime;
    protected $repeatFreqency;
    
    const IDENTIFIER = 'L';
    
	 
    
    protected function getIdentifier()
    {
        return self::IDENTIFIER;
    }
    
    
    
    public function getValue()
    {
    	if (!$this->limitTime)
    	{
    		throw new \Exception('"Limit time" should be defined');
    	}
        if (isset($this->repeatFreqency)&&(!isset($this->warningTime)))
        {
        	throw new \Exception('"warning time" should be set when repeat frequency is set');
        }
        $values = array($this->limitTime);
        if (isset($this->warningTime))
        {
        	$values[] = $this->warningTime;
        	if (isset($this->repeatFreqency))
        	{
        		$values[] = $this->repeatFreqency;
        	}	
        }       
        return implode(':', $values);
    }
    
	public function getLimitTime()
    {
        return $this->limitTime;
    }

	public function getWarningTime()
    {
        return $this->warningTime;
    }

	public function getRepeatFreqency()
    {
        return $this->repeatFreqency;
    }

	public function setLimitTime($limitTime)
    {
        $this->limitTime = $limitTime;
        return $this;
    }

	public function setWarningTime($warningTime)
    {
        $this->warningTime = $warningTime;
        return $this;
    }

	public function setRepeatFreqency($repeatFreqency)
    {
        $this->repeatFreqency = $repeatFreqency;
        return $this;
    }    
}