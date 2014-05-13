<?php

namespace PbxAgi\ChannelDescriptor;

interface AbstractChannelDescriptorInterface

{
    function getTechnology();
    function getExtension();    
    function getUniqueid();    
    function setTechnology($technology);
    function setExtension($extension);
    function setUniqueid($uniqueid);
}