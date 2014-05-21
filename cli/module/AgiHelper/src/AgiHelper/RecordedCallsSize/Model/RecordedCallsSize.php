<?php
namespace AgiHelper\RecordedCallsSize\Model;
 
class RecordedCallsSize
{             
    public $total;

    public function exchangeArray($data)
    {
        $this->total     = (isset($data['total'])) ? $data['total'] : null;
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

  }
