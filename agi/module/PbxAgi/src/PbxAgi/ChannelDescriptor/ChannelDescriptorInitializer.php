<?php
namespace PbxAgi\ChannelDescriptor;

class ChannelDescriptorInitializer
{   
  public function initialize($instance, $matches)
  {
      $instance->setTechnology($matches[1]);
      $instance->setPeername($matches[2]);
      $instance->setUniqueid($matches[3]);
  }
}