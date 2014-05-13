<?php
namespace PbxAgi\ChannelDescriptor;

interface ChannelDescriptorParserInterface
{
    const CHANNEL_NUMBER_PARSER_DOUBLE_PATTERN = '/^(\w+)\/(\w+)-(\w+)$/';    
    const CHANNEL_NUMBER_PARSER_LOCAL_PATTERN = '/^(\w+)\/(\w+)@(\w+)-(\w+);(\w+)$/';    
    function parse($channelName);
}