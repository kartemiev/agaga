<?php
namespace Vpbxui\ConferenceFree\Model;

 
class ConferenceFree
{       
    public $confnumber;
   
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    public function exchangeArray($data)
    {
        $this->confnumber = (isset($data['confnumber'])) ? $data['confnumber'] : null;
        
    }
    
}
