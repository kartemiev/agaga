<?php
namespace PbxAgi\ChannelDescriptor;

use PbxAgi\ChannelDescriptor\AbstractChannelDescriptor;

class ChannelLocalDescriptor extends AbstractChannelDescriptor
{   
    public $context;
    public $extension;
    public $sequence;
	/**
     * @return the $context
     */
    public function getContext()
    {
        return $this->context;
    }

	/**
     * @param field_type $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }
	/**
     * @return the $extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

	/**
     * @param field_type $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }
	/**
     * @return the $sequence
     */
    public function getSequence()
    {
        return $this->sequence;
    }

	/**
     * @param field_type $sequence
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }



}