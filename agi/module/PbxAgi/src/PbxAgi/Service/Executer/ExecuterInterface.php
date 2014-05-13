<?php
namespace PbxAgi\Service\Executer;

use PbxAgi\Service\Executer\ExecuterInterface;

interface ExecuterInterface
{
    function exec($cmd);
}