<?php
namespace PbxAgi\Conference\Model;

interface ConferenceTableInterface
{
   function getConferenceByConfNumber($confnumber);    
   function getConferenceById($id);    
   function saveConference(Conference $conference);         
   function isValid($confnum);   
 }