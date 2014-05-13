<?php
namespace Vpbxui\Offday\Model;

interface OffdayTableInterface
{
    function fetchAll($select, $filter=null,$orderseq=null);
    function getOffday($id);       
    function saveOffday(Offday $extension);
    function deleteOffday($id);
    function getOffdayByDate($date);
    
}