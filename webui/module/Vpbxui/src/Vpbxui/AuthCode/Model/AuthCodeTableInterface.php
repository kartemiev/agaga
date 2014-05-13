<?php
namespace Vpbxui\AuthCode\Model;

use Vpbxui\AuthCode\Model\AuthCode;

interface AuthCodeTableInterface
{
   function getAuthCodeById($id);
   function saveAuthCode(AuthCode $authCode);
   function fetchAll($select, $filter,$orderseq);
   function deleteAuthCode($id);
}