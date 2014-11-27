<?php
namespace Vpbxui\NumberMatch\Model;

interface NumberMatchTableInterface
{
    function fetchAll($filter=null,$orderseq=null);    
    function getNumberMatch($id);       
    function saveNumberMatch(NumberMatch $numbermatch);    
    function deleteNumberMatch($id); 
    function deleteAllNumberMatches();    
}