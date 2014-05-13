<?php
namespace PbxAgi\ChannelDescriptor;

class ChannelLocalDescriptorInitializer
{   
   
   public function initialize($instance, $matches)
  {
      $instance->setTechnology($matches[1]);
      $instance->setExtension($matches[2]);
      $instance->setContext($matches[3]);
      $instance->setUniqueid($matches[4]);
  }
}