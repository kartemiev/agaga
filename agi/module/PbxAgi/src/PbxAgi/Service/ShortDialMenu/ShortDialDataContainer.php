<?php
namespace PbxAgi\Service\ShortDialMenu;

use PbxAgi\Service\ShortDialMenu\ShortDialDataContainerInterface;

class ShortDialDataContainer implements ShortDialDataContainerInterface
{ 
    protected $number;
    protected $short;
	public function getNumber()
    {
        return $this->number;
    }

	public function getShort()
    {
        return $this->short;
    }

	public function setNumber($number)
    {
        $this->number = $number;
    }

	public function setShort($short)
    {
        $this->short = $short;
    }

}