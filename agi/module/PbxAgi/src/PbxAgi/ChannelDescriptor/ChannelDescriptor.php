<?php
namespace PbxAgi\ChannelDescriptor;

use PbxAgi\ChannelDescriptor\AbstractChannelDescriptor;

class ChannelDescriptor extends AbstractChannelDescriptor
{
    public $peername;
	/**
     * @return the $peername
     */
    public function getPeername()
    {
        return $this->peername;
    }

	/**
     * @param field_type $peername
     */
    public function setPeername($peername)
    {
        $this->peername = $peername;
    }    
}