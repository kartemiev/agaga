<?php
namespace PbxAgi\ChannelDescriptor;

class ChannelDescriptorParseError
{
    public $code;
    public $message;
	/**
     * @return the $code
     */
    public function getCode()
    {
        return $this->code;
    }

	/**
     * @return the $message
     */
    public function getMessage()
    {
        return $this->message;
    }

	/**
     * @param field_type $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

	/**
     * @param field_type $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }    
}