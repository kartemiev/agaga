<?php
namespace PbxAgi\Entity;

interface CallBearerInterface
{

	function exchangeArray($data);
	
	function getArrayCopy();
	
    function setId($id);

    function getId();
    
    function getName();
 
    function setName($name);
 
    function getExtension();
 
    function setExtension($extension);
 
    function getExtensionType();
 
    function setExtensionType($extensiontype);
    
    function getOperatorstatus();    
    
    function setOperatorstatus($operatorstatus);
    
    function getMailbox();

    function setMailbox($mailbox);

    function getPeerType();
    
    function setPeerType($peertype);
    
    function getRouteref();
    
    function setRouteref($routeref);
    
    function getNumberStatus(); 
    
    function setNumberStatus($numberstatus);
    
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
    
    function getDiversionUnavailDuration();
    
    function setDiversionUnavailDuration($x);
    
    function getVpbxid();
    
    function setVpbxid($vpbxid);

}