<?php
namespace PbxAgi\ChannelDescriptor;

use PbxAgi\ChannelDescriptor\AbstractChannelDescriptorInterface;

interface  ChannelDescriptorInterface extends AbstractChannelDescriptorInterface
{
    public function getPeername();
    public function setPeername($peername);            
}