<?php
namespace Maintainer\Service\LockHandler;

use Maintainer\Service\LockHandler\LockHandlerInterface;

class LockHandler implements LockHandlerInterface
{
    protected $lockFileName;
    
    public function closeLock()
    {
    	$result = unlink($this->lockFileName);
    	if (!$result)
    	{
    	    throw new \Exception('Failed to delete lock file');
    	}
    }
    public function isLocked()
    {
        return (file_exists($this->lockFileName));
    }
    public function touchLock()
    {
    	$result = touch($this->lockFileName);
    	if (!$result)
    	{
    	    throw new \Exception('Failed to open lock file');
    	}
    }
    
    public function setLockFileName($lockFileName) {
        $this->lockFileName = $lockFileName;
        return $this;
    } 
}