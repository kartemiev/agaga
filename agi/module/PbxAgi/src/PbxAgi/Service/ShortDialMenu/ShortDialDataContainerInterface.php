<?php
namespace PbxAgi\Service\ShortDialMenu;

interface ShortDialDataContainerInterface
{
    public function getNumber();    
    public function getShort();
    public function setNumber($number);
    public function setShort($short);
}