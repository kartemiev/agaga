<?php
namespace PbxAgi\Service\BuildAbstractMenu;

use PAGI\Node\Node;

interface NodeCmdValidatorInterface
{
    function validate(Node $node);    
}