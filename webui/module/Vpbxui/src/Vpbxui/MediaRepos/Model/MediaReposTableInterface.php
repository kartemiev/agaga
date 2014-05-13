<?php
namespace Vpbxui\MediaRepos\Model;

interface MediaReposTableInterface
{
    function fetchAll($filter=null);       
    function getMediaReposById($id, $vpbxid);
    function saveMediaRepos(MediaRepos $mediarepos);
    function deleteMediaRepos($id);
}