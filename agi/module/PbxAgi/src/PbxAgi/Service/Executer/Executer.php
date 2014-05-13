<?php
namespace PbxAgi\Service\Executer;

use PbxAgi\Service\Executer\ExecuterInterface;

class Executer implements ExecuterInterface
{
  	function exec($cmd)
    {
        return exec($cmd);
    }  
}