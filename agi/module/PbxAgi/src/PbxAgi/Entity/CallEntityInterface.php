<?php
namespace PbxAgi\Entity;

  
interface CallEntityInterface
{
    
    function getCallOwner();

    function setCallOwner($callOwner);

    function getCallOriginator();

    function setCallOriginator($callOriginator);

    function getCallDestinator();

    function setCallDestinator($callDestinator);

    function getExten();
    
    function setExten($exten);

    function getError();
    
    function setError($error);

    function getUniqueid();
    
    function setUniqueid($uniqueid);
    
    function getTransfered();
    
    function setTransfered($transfered);
 
}
