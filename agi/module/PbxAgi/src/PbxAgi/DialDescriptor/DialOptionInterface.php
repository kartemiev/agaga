<?php
namespace PbxAgi\DialDescriptor;

interface DialOptionInterface
{
    function enable();
    function disable();
    function getStatus();
}