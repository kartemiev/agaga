<?php
namespace PbxAgi\Service\ConferenceMenu;

interface ConferenceCredentialsContainerInterface
{
   function getConfpin();    
   
   function getConfnumber();    
   
   function setConfpin($confpin);
   
   function setConfnumber($confnumber);
   
   function getJoinacl();
   
   function setJoinacl($joinacl);
   
}