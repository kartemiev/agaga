<?php
namespace PbxAgi\OperatorStatusLog\Model;

interface OperatorStatusLogInterface {
   function getExtension();

   function setExtension($extension);

   function getOperatorstatus();

   function setOperatorstatus($operatorstatus);
}