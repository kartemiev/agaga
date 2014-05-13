<?php
namespace PbxAgi\DialDescriptor\DialOptions;
use PbxAgi\DialDescriptor\DialOptionInterface;

interface RingBackDahdiDialOptionInterface extends DialOptionInterface
{
   public function getMode();
   public function setMode($mode);
}