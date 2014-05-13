<?php
namespace PbxAgi\Operator\Model;

interface OperatorTableInterface
{
    function fetchAll();
    
    function getOperator($extension);
    
    function saveOperator(OperatorInterface $operator);

}
