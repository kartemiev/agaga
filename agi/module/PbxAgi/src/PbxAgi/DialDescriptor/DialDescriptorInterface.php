<?php
namespace PbxAgi\DialDescriptor;

interface DialDescriptorInterface
{
    function assemble();
    function getTypeIdentifier();
    function getTimeout();
    function getOptions();    
    function getUrl();    
    function setTypeIdentifier($typeIdentifier);    
    function setTimeout($timeout);    
    function setUrl($url);
    
}