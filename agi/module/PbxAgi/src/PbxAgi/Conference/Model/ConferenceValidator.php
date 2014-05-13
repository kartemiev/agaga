<?php
namespace PbxAgi\Conference\Model;

use PbxAgi\Conference\Model\ConferenceTableInterface;
use PbxAgi\Conference\Model\ConferenceValidatorInterface;


class ConferenceValidator  implements ConferenceValidatorInterface {
    protected $conferenceTable;
    public function __construct(ConferenceTableInterface $conferenceTable)
    {  
        $this->conferenceTable = $conferenceTable;    
    }
    public function isValid($value) {
        return $this->conferenceTable->isValid($value);
    }   
    
}
