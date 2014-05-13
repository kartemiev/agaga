<?php
namespace PbxAgi\Service\ClientImpl;

class Peer
{

    public $technology;

    public  $name;

    public function __construct($technology, $name)
    {
        $this->technology = $technology;
        $this->name = $name;
    }

    public function getTechnology()
    {
        return $this->technology;
    }

    public function setTechnology($technology)
    {
        $this->technology = $technology;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
