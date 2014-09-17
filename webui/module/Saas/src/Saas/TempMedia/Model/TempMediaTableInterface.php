<?php
namespace Saas\TempMedia\Model;

interface TempMediaTableInterface
{
  function fetchAll($filter=null);   
  function getTempMediaById($id);
  function saveTempMedia(TempMedia $tempmedia);
  function deleteTempMedia($id);
  function getDefaultGreetings();
  
}