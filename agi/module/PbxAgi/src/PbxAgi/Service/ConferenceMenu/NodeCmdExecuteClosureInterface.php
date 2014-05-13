<?php
namespace PbxAgi\Service\ConferenceMenu;

use PAGI\Node\Node;

interface NodeCmdExecuteClosureInterface
{
    function doRun(Node $node);    
}