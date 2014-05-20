<?php
namespace Maintainer\Service\LockHandler;

interface LockHandlerInterface
{
    public function closeLock();
     
    public function isLocked();

    public function touchLock();
        
    public function setLockFileName($lockFileName);
}