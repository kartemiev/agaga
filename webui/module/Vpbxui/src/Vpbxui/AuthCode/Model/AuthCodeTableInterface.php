<?php
namespace Vpbxui\AuthCode\Model;

use Vpbxui\AuthCode\Model\AuthCode;

interface AuthCodeTableInterface
{
   function getAuthCodeById($id);
   function saveAuthCode(AuthCode $authCode);
   function fetchAll($filter = null,$orderseq = null);
   function deleteAuthCode($id);
}