<?php
namespace Vpbxui\FaxUserEmail\Model;

interface FaxUserEmailTableInterface
{ 
    function getFaxUserEmailsByFaxUserId($userref);
    function saveFaxUserEmail(FaxUserEmail $faxuseremail);    
    function deleteFaxUserEmails($userref);
}