<?php
namespace PbxAgi\DialDescriptor;

interface  DialOptionsContextExtensionInterface

{
    function getContext();
    function getExtension();
    function getPriority();
    function setContext($context);
    function setExtension($extension);
    function setPriority($priority);    
}