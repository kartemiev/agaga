<?php
namespace PbxAgi\Media\Model;

interface MediaInterface
{

    const VPBX_MEDIATYPE_CALLRECORDING = 'RECORDING';

    function exchangeArray($data);

    function getArrayCopy();

    function getId();

    function getFilename();

    function getMediatype();

    function setId($id);

    function setFilename($filename);

    function setMediatype($mediatype);
}