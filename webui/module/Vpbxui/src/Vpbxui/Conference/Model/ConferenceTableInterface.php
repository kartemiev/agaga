<?php
namespace Vpbxui\Conference\Model;

interface ConferenceTableInterface
{
   function getConferenceByConfNumber($confnumber);    
   function getConferenceById($id);    
   function saveConference(Conference $conference);         
   function isValid($confnum);  
   function fetchAll($filter=null);    
 }