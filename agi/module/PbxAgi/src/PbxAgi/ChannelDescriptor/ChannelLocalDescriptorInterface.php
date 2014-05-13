<?php
namespace PbxAgi\ChannelDescriptor;

use PbxAgi\ChannelDescriptor\AbstractChannelDescriptorInterface;

interface ChannelLocalDescriptorInterface extends AbstractChannelDescriptorInterface
{
   function getContext(); 
   function setContext($context);   
   function getExtension();
   function setExtension($extension);
   function getSequence();
   function setSequence($sequence);    
}