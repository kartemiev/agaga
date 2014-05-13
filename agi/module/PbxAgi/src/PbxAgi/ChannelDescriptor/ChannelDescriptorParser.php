<?php
namespace PbxAgi\ChannelDescriptor;

use PbxAgi\ChannelDescriptor\ChannelDescriptorParserInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class ChannelDescriptorParser implements ChannelDescriptorParserInterface, ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    
    public function parse($channelName)
    {
        if (preg_match(self::CHANNEL_NUMBER_PARSER_DOUBLE_PATTERN, $channelName,
            $matches))
        {
            $instance = $this->getChannelDescriptor();
            $initializer = $this->getChannelDescriptorInitializer();
            $initializer->initialize($instance, $matches);
        } elseif (preg_match(self::CHANNEL_NUMBER_PARSER_LOCAL_PATTERN, $channelName,
            $matches))
        {
            $technology = $matches[1];           
            if ('Local' == $technology)
            {
                $instance = $this->getChannelLocalDescriptor();
                $initializer = $this->getChannelLocalDescriptorInitializer();
                $initializer->initialize($instance, $matches);       
            }             
        }
        if (!isset($instance)||(!$instance)) {
            $instance = $this->getChannelDescriptorParseError();
        }
        return $instance;        
    }
    protected function getChannelDescriptor()
    {
        return $this->serviceLocator->get('PbxAgi\ChannelDescriptor\ChannelDescriptor');
    }
    protected function getChannelLocalDescriptor()
    {
        return $this->serviceLocator->get('PbxAgi\ChannelDescriptor\ChannelLocalDescriptor');        
    }
    protected function getChannelDescriptorInitializer()
    {
        return $this->serviceLocator->get('PbxAgi\ChannelDescriptor\ChannelDescriptorInitializer');
    }
    protected function getChannelLocalDescriptorInitializer()
    {
        return $this->serviceLocator->get('PbxAgi\ChannelDescriptor\ChannelLocalDescriptorInitializer');
    }
    protected function getChannelDescriptorParseError()
    {
        return $this->serviceLocator->get('PbxAgi\ChannelDescriptor\ChannelDescriptorParseError');
    }
	/**
     * @return the $serviceLocator
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

	/**
     * @param field_type $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
    
}