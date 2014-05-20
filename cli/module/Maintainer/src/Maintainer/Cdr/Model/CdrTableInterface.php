<?php
namespace Maintainer\Cdr\Model;

interface CdrTableInterface
{
    function fetchAll($filter = null, $orderseq = null);
            
    function getCdr($id);
    
    function saveCdr(Cdr $cdr);
     
    function getTableGateway();
    
    function beginTransaction();
     
    function commit();
    
    function updateBackupDateOnly($id);
        
}