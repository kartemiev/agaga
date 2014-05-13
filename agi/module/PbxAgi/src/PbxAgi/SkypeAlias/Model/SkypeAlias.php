<?php
namespace PbxAgi\SkypeAlias\Model;

class SkypeAlias  
{
    public $id;
    public $number;
    public $skypeid;
   	public $custname;
   	public $custdesc;
     
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;        
        $this->number     = (isset($data['number'])) ? $data['number'] : null;
        $this->skypeid     = (isset($data['skypeid'])) ? $data['skypeid'] : null;    
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;
        
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

   
      
 }
