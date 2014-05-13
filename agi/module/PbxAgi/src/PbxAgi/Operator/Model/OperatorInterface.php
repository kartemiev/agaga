<?php
namespace PbxAgi\Operator\Model;

interface OperatorInterface {
    
   function exchangeArray($data);    
    
   function getArrayCopy();
   
   function getId();
   
   function setId($id);
   
   function getExtension();

   function setExtension($extension);

   function getExtensiontype();

   function setExtensiontype($extensiontype);
   
   function getName();
   
   function setName($name);

   function getOperatorstatus();

   function setOperatorstatus($operatorstatus);
}
