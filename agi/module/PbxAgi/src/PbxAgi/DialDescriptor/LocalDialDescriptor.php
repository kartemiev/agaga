<?php
namespace PbxAgi\DialDescriptor;

use PAGI\DialDescriptor\DialDescriptor;

class LocalDialDescriptor extends DialDescriptor
{
    const TECHNOLOGY = 'Local';

    /**
     * SIP provider.
     *
     * @var string
     */
    protected $provider = null;

    /**
     * (non-PHPdoc)
     * @see DialDescriptor::getTechnology()
     */
    public function getTechnology()
    {
        return self::TECHNOLOGY;
    }

    /**
     * (non-PHPdoc)
     * @see DialDescriptor::getChannelDescriptor()
     */
    public function getChannelDescriptor()
    {
        $descriptor = self::TECHNOLOGY .'/'.$this->target.'@'.$this->provider;

        return $descriptor;
    }

    /**
     * Class constructor.
     *
     * @param string $target dial target
     */
    public function __construct($target, $provider)
    {
        $this->target = $target;
        $this->provider = $provider;
    }

    /**
     * Set SIP provider.
     *
     * @param string $provider SIP provider
     *
     * @return void
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

}