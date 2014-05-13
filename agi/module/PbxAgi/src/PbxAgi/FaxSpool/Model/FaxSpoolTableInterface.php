<?php
namespace PbxAgi\FaxSpool\Model;

use PbxAgi\FaxSpool\Model\FaxSpool;

interface FaxSpoolTableInterface
{
    function saveFax(FaxSpool $fax);
}