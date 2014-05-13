<?php
namespace PbxAgi\FaxUser\Model;

interface FaxUserTableInterface
{
    function getFaxUserByEmail($email);	
}