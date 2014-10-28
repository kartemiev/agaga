<?php
namespace PbxAgi\Extension\Model;

interface ExtensionInterface 
{ 
 
 
    function getName();
  
    function setName($name);
    
    function getId();
   
    function setId($id);
    

    function getExtension();
   

    function setExtension($extension);
    

    function getExtensiontype();
    

    function setExtensiontype($extensiontype);
    
 
    
    function getExtensiongroup();

    function setExtensiongroup($extensiongroup);   
   
    function setOutgoingcallspermission($outgoingcallspermission);
   
    function setTransfer($transfer);
   
    function setStatuschange($statuschange);   
   
    function setIncoming($incoming);
   
    function setHold($hold);
   
    function setForwarding($forwarding);
   
    function setMemberofcallcentreque($memberofcallcentreque);
    
    function getMailbox();
   
    function setMailbox($mailbox);
        
    function setCallsequence($callseqence);
     
    function getCallsequence();
  
    function getNumberStatus();
    
    function setNumberStatus($number_status);
    function getPeerType();
    function setPeerType($peertype);
    
    function getDiversionUnconditionalStatus();
     
    function getDiversionUnconditionalNumber();
    
    function getDiversionUnavailStatus();

    function getDiversionUnavailNumber();
    
    function getDiversionBusyStatus();
    
    function getDiversionBusyNumber();
    
    function getDiversionNoanswerStatus();
    
    function getDiversionNoanswerNumber();
    
    function setDiversionUnconditionalStatus($x);
    
    function setDiversionUnconditionalNumber($x);
    
    function setDiversionUnavailStatus($x);
    
    function setDiversionUnavailNumber($x);
    
    function setDiversionBusyStatus($x);
    
    function setDiversionBusyNumber($x);
    
    function setDiversionNoanswerStatus($x);
    
    function setDiversionNoanswerNumber($x);    
    
    function setDiversionNoanswerDuration($diversion_noanswer_duration); 
    
    function getDiversionNoanswerDuration();
    
    function getVpbxid();
    
    function setVpbxid($vpbxid);
    
}
