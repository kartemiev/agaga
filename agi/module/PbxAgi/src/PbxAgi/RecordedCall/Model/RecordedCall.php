<?php
namespace PbxAgi\RecordedCall\Model;
 
class RecordedCall
{             
    public $id;
    public $cdrref;
    public $filesize;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->cdrref     = (isset($data['cdrref'])) ? $data['cdrref'] : null;
        $this->filesize     = (isset($data['filesize'])) ? $data['filesize'] : null;
        
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

  }
